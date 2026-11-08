<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cap Coffee System</title>
    <style>
        body { font-family: Arial; background: #f5f0e6; text-align: center; padding-top: 100px; }
        .container { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); max-width: 400px; margin: auto; }
        h1 { color: #6f4e37; }
        .btn { display: inline-block; padding: 12px 30px; margin: 10px; background: #6f4e37; color: white; text-decoration: none; border-radius: 5px; font-size: 16px; }
        .btn:hover { background: #543a29; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cap Coffee System</h1>
        <p>Welcome! Please login or create an account to continue.</p>
        <a href="login.php" class="btn">Login</a>
        <a href="register.php" class="btn">Register</a>
    </div>
</body>
</html>