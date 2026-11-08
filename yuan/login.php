<?php
session_start();
include "config_database.php";

$error = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($user && password_verify($password, $user['password'])) {
        if($user['status'] == 'approved') {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Your account is pending approval from admin.";
        }
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Cap Coffee</title>
    <style>
        body { font-family: Arial; background: #f5f0e6; padding-top: 80px; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); max-width: 350px; margin: auto; }
        h2 { text-align: center; color: #6f4e37; }
        .error { background: #ffdddd; color: #d8000c; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        input { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #6f4e37; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; }
        button:hover { background: #543a29; }
        p { text-align: center; margin-top: 15px; }
        a { color: #6f4e37; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2> Login</h2>
        <?php if($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        <p><a href="index.php"> Back to Home</a></p>
    </div>
</body>
</html>