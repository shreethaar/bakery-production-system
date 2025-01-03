<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .dashboard-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .dashboard-header h1 {
            font-size: 36px;
            color: #333;
        }
        .dashboard-content {
            display: flex;
            justify-content: space-around;
        }
        .dashboard-card {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 30%;
            text-align: center;
        }
        .dashboard-card h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }
        .dashboard-card p {
            font-size: 18px;
            color: #666;
        }
        .logout-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #28a745;
            text-decoration: none;
        }
        .logout-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Welcome to the Dashboard</h1>
        </div>
        <div class="dashboard-content">
            <div class="dashboard-card">
                <h2>Recipes</h2>
                <p>Manage your recipes here.</p>
                <a href="/recipes">Go to Recipes</a>
            </div>
            <div class="dashboard-card">
                <h2>Production</h2>
                <p>Schedule and track production.</p>
                <a href="/production">Go to Production</a>
            </div>
            <div class="dashboard-card">
                <h2>Batches</h2>
                <p>Track batch progress.</p>
                <a href="/batch">Go to Batches</a>
            </div>
        </div>
        <a href="/logout" class="logout-link">Logout</a>
    </div>
</body>
</html>
