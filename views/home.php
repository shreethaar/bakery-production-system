<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Bakery Production System</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: rgb(2,0,36);
            background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(50,50,175,1) 69%, rgba(0,212,255,1) 100%); 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }
        .welcome-container {
            text-align: center;
            background-color: #fff;
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 90%;
        }
        .welcome-container h1 {
            font-size: 40px;
            margin-bottom: 20px;
            color: #4a4a4a;
        }
        .welcome-container p {
            font-size: 18px;
            margin-bottom: 30px;
            line-height: 1.6;
            color: #555;
        }
        .welcome-container a {
            display: inline-block;
            padding: 12px 25px;
            background: linear-gradient(135deg, #28a745, #3ddc84);
            color: #fff;
            text-decoration: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .welcome-container a:hover {
            background: linear-gradient(135deg, #218838, #2ac573);
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>Welcome to the Bakery Production System</h1>
        <p>Manage your bakery production efficiently and effectively.</p>
        <a href="/login">Get Started</a>
    </div>
</body>
</html>
