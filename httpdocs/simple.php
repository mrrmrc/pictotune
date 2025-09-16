<?php
session_start();

// Login semplice
if (!isset($_SESSION["admin_logged"])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if ($_POST["email"] === "admin@pictotune.com" && $_POST["password"] === "admin123") {
            $_SESSION["admin_logged"] = true;
            header("Location: simple.php");
            exit;
        } else {
            $error = "Credenziali errate";
        }
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Login Admin</title>
        <style>
            body { font-family: Arial; background: #667eea; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
            .login-box { background: white; padding: 40px; border-radius: 10px; width: 300px; }
            input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
            button { width: 100%; padding: 12px; background: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer; }
            .error { color: red; margin: 10px 0; }
        </style>
    </head>
    <body>
        <div class="login-box">
            <h2>Admin Login</h2>
            <?php if (isset($error)) echo "<div class=\"error\">$error</div>"; ?>
            <form method="POST">
                <input type="email" name="email" placeholder="Email" value="admin@pictotune.com" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <p style="margin-top: 20px; color: #666; font-size: 14px;">
                Default:<br>
                Email: admin@pictotune.com<br>
                Pass: admin123
            </p>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Database config
define("DB_HOST", "localhost");
define("DB_NAME", "km616q2x_Sql1234567");
define("DB_USER", "km616q2x_Sql1234567");
define("DB_PASS", "FLstudio2025!");

// Cambio password
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"])) {
    if ($_POST["action"] === "change_password") {
        try {
            $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $new_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->execute([$new_password, "admin@pictotune.com"]);
            $message = "✅ Password cambiata! Nuova password: " . $_POST["new_password"];
            $_SESSION["admin_logged"] = false; // Force re-login
        } catch (PDOException $e) {
            $message = "❌ Errore: " . $e->getMessage();
        }
    }
}

// Stats
try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $users = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $generations = $db->query("SELECT COUNT(*) FROM generations")->fetchColumn();
} catch (PDOException $e) {
    $users = "Errore";
    $generations = "Errore";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - PictoTune</title>
    <style>
        body { font-family: Arial; margin: 0; background: #f5f5f5; }
        .header { background: #667eea; color: white; padding: 20px; }
        .container { padding: 20px; max-width: 800px; margin: 0 auto; }
        .card { background: white; padding: 20px; margin: 20px 0; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .stats { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .stat { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { padding: 10px 20px; background: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .message { padding: 15px; background: #d4edda; color: #155724; border-radius: 5px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎵 PictoTune Admin Panel</h1>
        <p>Pannello di controllo semplificato</p>
    </div>
    
    <div class="container">
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="stats">
            <div class="stat">
                <h3>👥 Utenti Totali</h3>
                <p style="font-size: 32px; font-weight: bold; color: #667eea;"><?php echo $users; ?></p>
            </div>
            <div class="stat">
                <h3>🎵 Generazioni</h3>
                <p style="font-size: 32px; font-weight: bold; color: #667eea;"><?php echo $generations; ?></p>
            </div>
        </div>
        
        <div class="card">
            <h2>🔐 Cambia Password Admin</h2>
            <form method="POST">
                <input type="hidden" name="action" value="change_password">
                <label>Nuova Password (minimo 8 caratteri):</label>
                <input type="password" name="new_password" minlength="8" required>
                <button type="submit">Cambia Password</button>
            </form>
            <p style="color: #666; font-size: 14px; margin-top: 20px;">
                ⚠️ Dopo il cambio password dovrai fare login di nuovo con:<br>
                Email: admin@pictotune.com<br>
                Password: [la tua nuova password]
            </p>
        </div>
        
        <div class="card">
            <h2>🔗 Link Utili</h2>
            <p>
                <a href="../app/">🎵 Vai all'App</a><br><br>
                <a href="../">🏠 Home</a><br><br>
                <a href="logout.php">🚪 Logout</a>
            </p>
        </div>
    </div>
</body>
</html>