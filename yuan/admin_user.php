<?php
session_start();
include "config_database.php";


if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit;
}


if(isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];
    $status = ($action === 'approve') ? 'approved' : 'rejected';
    
    $stmt = $conn->prepare("UPDATE users SET status = :status WHERE id = :id");
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    header("Location: admin_users.php");
    exit;
}


$stmt = $conn->prepare("SELECT * FROM users ORDER BY created_at DESC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Management - Cap Coffee</title>
    <style>
        body { font-family: Arial; background: #f5f0e6; margin: 0; padding: 0; }
        .header { background: #6f4e37; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .header a { color: white; text-decoration: none; margin-left: 15px; }
        .content { max-width: 900px; margin: 30px auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { color: #6f4e37; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #6f4e37; color: white; }
        .status-pending { color: #e67700; font-weight: bold; }
        .status-approved { color: #2e7d32; font-weight: bold; }
        .status-rejected { color: #c62828; font-weight: bold; }
        .btn-approve { background: #4CAF50; color: white; padding: 5px 12px; text-decoration: none; border-radius: 4px; margin-right: 5px; }
        .btn-reject { background: #f44336; color: white; padding: 5px 12px; text-decoration: none; border-radius: 4px; }
        .btn-approve:hover { background: #45a049; }
        .btn-reject:hover { background: #d32f2f; }
        .back-link { display: inline-block; margin-top: 20px; color: #6f4e37; text-decoration: none; }
    </style>
</head>
<body>
    <div class="header">
        <h2> User Management</h2>
        <div>
            <a href="dashboard.php"> Back to Dashboard</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <div class="content">
        <h2>Manage Registered Users</h2>
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach($users as $u): ?>
            <tr>
                <td><strong><?php echo $u['username']; ?></strong></td>
                <td><?php echo $u['email']; ?></td>
                <td><?php echo ucfirst($u['role']); ?></td>
                <td class="status-<?php echo $u['status']; ?>">
                    <?php echo ucfirst($u['status']); ?>
                </td>
                <td>
                    <?php if($u['status'] === 'pending' && $u['role'] !== 'admin'): ?>
                        <a href="admin_users.php?action=approve&id=<?php echo $u['id']; ?>" class="btn-approve">Approve</a>
                        <a href="admin_users.php?action=reject&id=<?php echo $u['id']; ?>" class="btn-reject">Reject</a>
                    <?php elseif($u['status'] === 'approved'): ?>
                         Approved
                    <?php elseif($u['status'] === 'rejected'): ?>
                         Rejected
                    <?php else: ?>
                        
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="dashboard.php" class="back-link"> Back to Dashboard</a>
    </div>
</body>
</html>