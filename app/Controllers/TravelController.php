<?php 
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\PlanModel;
use App\Models\ConfirmationModel;

class TravelController extends ResourceController
{

    public function getPlans()
    {
        $planModel = new PlanModel();
        
        $plans = $planModel->where('user_id', session()->get('id'))->findAll();
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['plans' => $plans]);
        }
        
        return view('plans/index', [
            'plans' => $plans
        ]);
    }

    // Create a new travel plan
    public function createPlan()
    {
        log_message('debug', 'User ID from session: ' . session()->get('id'));

        $planModel = new PlanModel();
        
        $rules = [
            'title' => 'required|min_length[3]',
            'start_date' => 'required|valid_date',
            'end_date' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['error' => $this->validator->getErrors()])->setStatusCode(400);
        }

        $data = [
            'title' => $this->request->getVar('title'),
            'start_date' => $this->request->getVar('start_date'),
            'end_date' => $this->request->getVar('end_date'),
            'user_id' => session()->get('id') // Associate plan with logged in user
        ];

        $planId = $planModel->insert($data);
        $data['id'] = $planId;
        
        return redirect()->to('/plans')->with('success', 'Plan created successfully');
    }

    // Add confirmation to a plan
    public function addConfirmation($planId)
    {
        try {
            // Enable error reporting
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            
            $confirmationModel = new ConfirmationModel();
            $planModel = new PlanModel();

            // Debug logging
            log_message('debug', 'Request data: ' . json_encode($this->request->getJSON()));
            
            // Verify plan ownership
            $plan = $planModel->where([
                'id' => $planId,
                'user_id' => session()->get('id')
            ])->first();
            
            if (!$plan) {
                log_message('error', 'Plan not found or unauthorized');
                return $this->failNotFound('Plan not found or unauthorized');
            }

            // Get JSON data
            $input = $this->request->getJSON(true);
            if (empty($input)) {
                log_message('error', 'Empty input data');
                return $this->fail('Empty input data');
            }

            $data = [
                'plan_id' => $planId,
                'type' => $input['type'] ?? null,
                'provider' => $input['provider'] ?? null,
                'booking_reference' => $input['booking_reference'] ?? null,
                'date' => $input['date'] ?? null,
                'time' => $input['time'] ?? null,
                'details' => $input['details'] ?? null
            ];

            // Validate required fields
            foreach ($data as $key => $value) {
                if ($value === null) {
                    log_message('error', "Missing required field: $key");
                    return $this->fail("Missing required field: $key");
                }
            }

            $insertId = $confirmationModel->insert($data);
            
            if (!$insertId) {
                log_message('error', 'Database insert failed: ' . json_encode($confirmationModel->errors()));
                return $this->fail('Failed to save confirmation');
            }

            return $this->respond([
                'status' => 200,
                'message' => 'Confirmation added successfully',
                'data' => array_merge($data, ['id' => $insertId])
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Add confirmation error: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            return $this->fail($e->getMessage());
        }
    }

    // Get plan with all confirmations
    public function getPlan($planId)
    {
        $planModel = new PlanModel();
        $confirmationModel = new ConfirmationModel();

        $plan = $planModel->where([
            'id' => $planId,
            'user_id' => session()->get('id')
        ])->first();
        
        if (!$plan) {
            return redirect()->to('/plans')->with('error', 'Plan not found');
        }

        $confirmations = $confirmationModel->where('plan_id', $planId)
            ->orderBy('date', 'ASC')
            ->orderBy('time', 'ASC')
            ->findAll();

        return view('plans/details', [
            'plan' => $plan,
            'confirmations' => $confirmations
        ]);
    }
}