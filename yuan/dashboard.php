<?php
session_start();
include "config_database.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Cap Coffee</title>
    <style>
        body { font-family: Arial; background: #f5f0e6; margin: 0; padding: 0; }
        .header { background: #6f4e37; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .header h2 { margin: 0; }
        .header a { color: white; text-decoration: none; background: #8b5a3c; padding: 8px 15px; border-radius: 5px; margin-left: 8px; }
        .header a:hover { background: #543a29; }
        .content { max-width: 800px; margin: 40px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #6f4e37; }
        .welcome { font-size: 18px; color: #555; }
        .admin-link { background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-bottom: 20px; }
        .admin-link:hover { background: #45a049; }
    </style>
</head>
<body>
    <div class="header">
        <h2> Cap Coffee System</h2>
        <span>Welcome, <strong><?php echo $_SESSION['username']; ?></strong> | 
        <a href="logout.php">Logout</a></span>
    </div>
    <div class="content">
        <h1>Welcome to Dashboard! </h1>
        <p class="welcome">Hello <strong><?php echo $_SESSION['username']; ?></strong>, you are now logged in successfully.</p>
        
        <?php if($_SESSION['role'] === 'admin'): ?>
            <a href="admin_users.php" class="admin-link"> Manage Users</a>
        <?php endif; ?>
        
        <p>This is your Cap Coffee management system. You can add features here like:</p>
        <ul>
            <li> Menu Management</li>
            <li> Orders</li>
            <li> Sales Report</li>
            <?php if($_SESSION['role'] === 'admin'): ?>
                <li> User Management  <em>You can approve new registrations here!</em></li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>