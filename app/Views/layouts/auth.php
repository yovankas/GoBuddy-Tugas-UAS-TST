<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoBuddy - Travel Planning Made Easy</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            min-height: 100vh;
            background-color: #f5f5f5;
        }

        .header {
            height: 68px;
            background: white;
            border-bottom: 1px solid #eee;
            padding: 0 24px;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: #1a1a1a;
        }

        .logo-icon {
            color: #2F80ED;
            font-size: 24px;
        }

        .logo-text {
            font-weight: 500;
            font-size: 18px;
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <a href="/" class="logo">
                <span class="logo-icon">✈</span>
                <span class="logo-text">GoBuddy</span>
            </a>
        </div>
    </header>

    <?= $this->renderSection('content') ?>
</body>
</html>

