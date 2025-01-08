<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakery Production System</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .navbar {
            background: linear-gradient(90deg, #1d3557, #457b9d, #a8dadc);
            padding: 10px 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .navbar .logo {
            font-size: 20px;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
        }
        .navbar .links {
            display: flex;
            gap: 15px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background 0.3s ease;
        }
        .navbar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
        .login-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 50px auto;
        }
        .login-form h2 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }
        .login-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .login-form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .login-form button:hover {
            background-color: #218838;
        }
        @media (max-width: 768px) {
            .navbar {
                flex-wrap: wrap;
            }
            .navbar .links {
                width: 100%;
                justify-content: center;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">Bakery</div>
        <div class="links">
            <a href="/">Home</a>
            <a href="/recipes">Recipes</a>
            <a href="/production">Production</a>
            <a href="/batch">Batches</a>
        </div>
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/logout">Logout</a>
            <?php else: ?>
                <a href="/login">Login</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="container">
