<?php
session_start();

// Check if admin
if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../api/config.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - PictoTune</title>
    <style>
        body { font-family: Arial; margin: 0; background: #f5f5f5; }
        .header { background: #667eea; color: white; padding: 20px; }
        .container { padding: 20px; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .stat-value { font-size: 32px; font-weight: bold; color: #667eea; }
        a { color: #667eea; text-decoration: none; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎶 PictoTune Admin</h1>
        <a href="logout.php" style="color: white;">Logout</a>
    </div>
    <div class="container">
        <h2>Dashboard</h2>
        <div class="stats">
            <div class="stat-card">
                <div>Utenti Totali</div>
                <div class="stat-value">0</div>
            </div>
            <div class="stat-card">
                <div>Generazioni</div>
                <div class="stat-value">0</div>
            </div>
            <div class="stat-card">
                <div>Crediti Venduti</div>
                <div class="stat-value">0</div>
            </div>
        </div>
    </div>
</body>
</html>