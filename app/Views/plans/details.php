<?= $this->extend('plans/layouts/main') ?>

<?= $this->section('content') ?>
<div class="page-container">
    <!-- Back Navigation -->
    <div class="back-nav">
        <a href="<?= base_url('plans') ?>" class="back-link">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M20 12H4M4 12L10 18M4 12L10 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Back to trips</span>
        </a>
    </div>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title"><?= $plan['title'] ?></h1>
            <div class="date-group">
                <p class="date">Start date: <?= date('l, F j, Y', strtotime($plan['start_date'])) ?></p>
                <p class="date">End date: <?= date('l, F j, Y', strtotime($plan['end_date'])) ?></p>
            </div>
        </div>
    </div>

    <!-- Add Confirmation Section -->
    <section class="confirmation-section">
        <h2 class="section-title">Add confirmation details</h2>
        <div class="form-container">
            <form id="confirmationForm" class="confirmation-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select id="type" name="type" class="form-input">
                            <option value="transportation">Transportation</option>
                            <option value="hotel">Hotel</option>
                            <option value="attraction">Attraction</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="provider">Provider</label>
                        <input type="text" id="provider" name="provider" class="form-input">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="booking_reference">Booking Reference</label>
                        <input type="text" id="booking_reference" name="booking_reference" class="form-input">
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" class="form-input">
                    </div>
                    <div class="form-group">
                        <label for="time">Time</label>
                        <input type="time" id="time" name="time" class="form-input">
                    </div>
                </div>

                <div class="form-group">
                    <label for="details">Details</label>
                    <textarea id="details" name="details" class="form-input"></textarea>
                </div>

                <button type="submit" class="submit-btn">Add confirmation</button>
            </form>
        </div>
    </section>

    <!-- Trip Schedule Section -->
    <section class="schedule-section">
        <h2 class="section-title">Trip schedule</h2>
        <?php if (!empty($confirmations)): ?>
            <div class="timeline">
                <?php 
                usort($confirmations, function($a, $b) {
                    return strtotime($a['date']) - strtotime($b['date']);
                });
                foreach ($confirmations as $confirmation): ?>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="confirmation-card">
                                <div class="card-header">
                                    <h3 class="card-title capitalize">
                                        <?= $confirmation['type'] ?>
                                    </h3>
                                    <span class="card-date">
                                        <?= date('l, F j, Y', strtotime($confirmation['date'])) ?>
                                        <?= $confirmation['time'] ? date('H:i', strtotime($confirmation['time'])) : '' ?>
                                    </span>
                                </div>
                                <div class="card-body">
                                    <p class="provider-info">
                                        <span>Provider:</span>
                                        <strong><?= $confirmation['provider'] ?></strong>
                                    </p>
                                    <p class="reference-info">
                                        <span>Reference:</span>
                                        <strong><?= $confirmation['booking_reference'] ?></strong>
                                    </p>
                                    <p class="details-info"><?= $confirmation['details'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                No confirmations added yet
            </div>
        <?php endif; ?>
    </section>

    <!-- COVID Notice -->
    <div class="covid-notice">
        <span class="warning-icon">⚠️</span>
        <p>Check the latest COVID-19 restrictions before you travel. <a href="/learn-more">Learn more</a></p>
    </div>
</div>

<style>
.page-container {
    width: 100%;
    min-height: 100vh;
    background: #F4F4F4;
    padding-bottom: 32px;
}

.back-nav {
    padding: 24px 100px;
}

.back-link {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    color: #1B1F2D;
    font-size: 18px;
    font-weight: 500;
    letter-spacing: 0.02em;
}

.hero-section {
    width: 100%;
    height: 164px;
    background: linear-gradient(0deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.2)), url('https://images8.alphacoders.com/719/719571.jpg') center/cover;
    margin-bottom: 40px;
}

.hero-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 24px 100px;
}

.hero-title {
    margin-top: -0px;
    font-size: 40px;
    font-weight: 700;
    color: #FFFFFF;
    margin-bottom: 16px;
    letter-spacing: 0.01em;
}

.date-group {
    display: flex;
    gap: 66px;
}

.date {
    font-size: 14px;
    color: #FFFFFF;
    letter-spacing: 0.01em;
}

.section-title {
    font-size: 32px;
    font-weight: 600;
    color: #1A1A1A;
    letter-spacing: 0.01em;
    margin-bottom: 24px;
}

.confirmation-section,
.schedule-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 100px;
    margin-bottom: 40px;
}

.form-container {
    background: #FFFFFF;
    border: 1px solid #E0E0E0;
    border-radius: 5px;
    padding: 24px;
}

.confirmation-form {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 24px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group label {
    font-size: 14px;
    font-weight: 500;
    color: #181818;
    letter-spacing: 0.02em;
}

.form-input {
    height: 44px;
    background: #F2F2F2;
    border: none;
    border-radius: 4px;
    padding: 11px 12px;
    font-size: 15px;
    color: #333333;
}

textarea.form-input {
    height: auto;
    min-height: 100px;
    resize: vertical;
}

.submit-btn {
    width: 150px;
    height: 40px;
    background: #2F80ED;
    border: none;
    border-radius: 6px;
    color: #FFFFFF;
    font-weight: 500;
    font-size: 15px;
    margin: 0 auto;
    cursor: pointer;
}

.timeline {
    background: #FFFFFF;
    border: 1px solid #E0E0E0;
    border-radius: 5px;
    padding: 24px;
}

.timeline-item {
    position: relative;
    padding-left: 48px;
    margin-bottom: 24px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: 0;
    top: 8px;
    width: 18px;
    height: 18px;
    background: #2F80ED;
    border-radius: 50%;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 26px;
    width: 2px;
    height: calc(100% + 24px);
    background: rgba(47, 128, 237, 0.6);
}

.confirmation-card {
    background: #FFFFFF;
    border: 1px solid #E0E0E0;
    border-radius: 5px;
    padding: 16px;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.card-title {
    font-size: 20px;
    font-weight: 500;
    color: #1A1A1A;
}

.card-date {
    font-size: 14px;
    color: #4F4F4F;
}

.card-body p {
    margin-bottom: 8px;
    font-size: 16px;
    color: #4F4F4F;
}

.card-body p:last-child {
    margin-bottom: 0;
}

.card-body span {
    margin-right: 8px;
}

.card-body strong {
    font-size: 20px;
    font-weight: 600;
    color: #1A1A1A;
}

.empty-state {
    text-align: center;
    padding: 40px;
    color: #4F4F4F;
    background: #FFFFFF;
    border: 1px solid #E0E0E0;
    border-radius: 5px;
}

.covid-notice {
    max-width: 1200px;
    margin: 32px auto;
    padding: 16px 24px;
    background: #FCEFCA;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 16px;
}

.covid-notice p {
    font-size: 16px;
    color: #333333;
    letter-spacing: 0.02em;
}

.covid-notice a {
    color: #2F80ED;
    text-decoration: none;
}

.capitalize {
    text-transform: capitalize;
}

@media (max-width: 768px) {
    .back-nav,
    .hero-content,
    .confirmation-section,
    .schedule-section {
        padding: 0 24px;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .date-group {
        flex-direction: column;
        gap: 8px;
    }
}
</style>

<script>
document.getElementById('confirmationForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = {
        type: document.getElementById('type').value,
        provider: document.getElementById('provider').value,
        booking_reference: document.getElementById('booking_reference').value,
        date: document.getElementById('date').value,
        time: document.getElementById('time').value || '00:00',
        details: document.getElementById('details').value
    };

    try {
        const response = await fetch(`<?= base_url("plans/{$plan['id']}/confirmations") ?>`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        console.log('Response status:', response.status); // Debug line
        const data = await response.json();
        console.log('Response data:', data); // Debug line

        if (response.ok) {
            window.location.reload();
        } else {
            throw new Error(data.messages || 'Failed to add confirmation');
        }

    } catch (error) {
        alert('Error adding confirmation: ' + error.message);
    }
});
</script>
<?= $this->endSection() ?>