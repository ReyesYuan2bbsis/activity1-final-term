<?php
session_start();
include "config_database.php";

$error = $success = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } elseif(strlen($password) < 6) {
        $error = "Password must be at least 6 characters!";
    } else {
        try {
            $check = $conn->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
            $check->bindParam(':username', $username);
            $check->bindParam(':email', $email);
            $check->execute();
            
            if($check->rowCount() > 0) {
                $error = "Username or Email already exists!";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, status) VALUES (:username, :email, :password, 'user', 'pending')");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->execute();
                $success = "Account created! Waiting for admin approval.";
            }
        } catch(PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Cap Coffee</title>
    <style>
        body { font-family: Arial; background: #f5f0e6; padding-top: 60px; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); max-width: 350px; margin: auto; }
        h2 { text-align: center; color: #6f4e37; }
        .error { background: #ffdddd; color: #d8000c; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        .success { background: #ddffdd; color: #4F8A10; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        input { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #6f4e37; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; }
        button:hover { background: #543a29; }
        p { text-align: center; margin-top: 15px; }
        a { color: #6f4e37; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2> Register</h2>
        <?php if($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>
        <?php if($success): ?><div class="success"><?php echo $success; ?></div><?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
        <p><a href="index.php"> Back to Home</a></p>
    </div>
</body>
</html>