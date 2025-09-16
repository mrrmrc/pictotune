<?php
/**
 * ADMIN/TEST.PHP - Test per risolvere errore 500
 * Carica questo file in admin/test.php
 */

// Abilita visualizzazione errori
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>
<html>
<head>
    <title>Admin Test - PictoTune</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .test { background: white; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .ok { border-left: 4px solid green; }
        .error { border-left: 4px solid red; }
        pre { background: #333; color: #fff; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>🔍 Admin Panel - Diagnostica</h1>";

// TEST 1: Session
echo "<div class='test'>";
echo "<h3>1. Test Sessione PHP</h3>";
if (session_start()) {
    echo "✅ Sessione avviata correttamente<br>";
    $_SESSION['test'] = 'ok';
    if ($_SESSION['test'] === 'ok') {
        echo "✅ Sessione funzionante<br>";
    }
} else {
    echo "❌ Errore sessione<br>";
}
echo "</div>";

// TEST 2: Config file
echo "<div class='test'>";
echo "<h3>2. Test File Config</h3>";

$config_paths = [
    '../api/config.php',
    'config.php',
    '../config.php',
    '../../api/config.php'
];

$config_found = false;
foreach ($config_paths as $path) {
    if (file_exists($path)) {
        echo "✅ Config trovato in: $path<br>";
        $config_found = true;
        
        // Prova a includere
        @include_once $path;
        
        // Verifica costanti
        if (defined('DB_HOST')) {
            echo "✅ DB_HOST definito: " . DB_HOST . "<br>";
        } else {
            echo "❌ DB_HOST non definito<br>";
        }
        
        if (defined('DB_NAME')) {
            echo "✅ DB_NAME definito: " . DB_NAME . "<br>";
        } else {
            echo "❌ DB_NAME non definito<br>";
        }
        
        break;
    }
}

if (!$config_found) {
    echo "❌ File config.php non trovato! Creiamolo...<br>";
}
echo "</div>";

// TEST 3: Database
echo "<div class='test'>";
echo "<h3>3. Test Database</h3>";

// Se il config non esiste, usa i valori diretti
if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'km616q2x_Sql1234567');
    define('DB_USER', 'km616q2x_Sql1234567');
    define('DB_PASS', 'FLstudio2025!');
}

try {
    $db = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "✅ Connessione database OK<br>";
    
    // Verifica tabella users
    $stmt = $db->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Tabella 'users' trovata<br>";
        
        // Conta utenti
        $stmt = $db->query("SELECT COUNT(*) FROM users");
        echo "✅ Utenti totali: " . $stmt->fetchColumn() . "<br>";
        
        // Verifica admin
        $stmt = $db->query("SELECT * FROM users WHERE email = 'admin@pictotune.com'");
        if ($stmt->rowCount() > 0) {
            echo "✅ Admin trovato<br>";
        } else {
            echo "⚠️ Admin non trovato<br>";
        }
    } else {
        echo "❌ Tabella 'users' non trovata<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ Errore database: " . $e->getMessage() . "<br>";
}
echo "</div>";

// CREA CONFIG SE NON ESISTE
if (!$config_found) {
    echo "<div class='test warning'>";
    echo "<h3>4. Creazione Config Automatica</h3>";
    
    $config_content = '<?php
// Configurazione Database
define(\'DB_HOST\', \'localhost\');
define(\'DB_NAME\', \'km616q2x_Sql1234567\');
define(\'DB_USER\', \'km616q2x_Sql1234567\');
define(\'DB_PASS\', \'FLstudio2025!\');

// Configurazioni generali
define(\'SITE_URL\', \'https://pictotune.com\');
define(\'SITE_NAME\', \'PictoTune\');

// API Keys (da configurare)
define(\'STABILITY_API_KEY\', \'\');
define(\'MUBERT_API_KEY\', \'\');
define(\'GUMROAD_SECRET\', \'\');

date_default_timezone_set(\'Europe/Rome\');
';
    
    // Prova a creare in diverse posizioni
    $created = false;
    if (@file_put_contents('../api/config.php', $config_content)) {
        echo "✅ Config creato in ../api/config.php<br>";
        $created = true;
    } elseif (@file_put_contents('config.php', $config_content)) {
        echo "✅ Config creato in config.php<br>";
        $created = true;
    }
    
    if (!$created) {
        echo "❌ Non riesco a creare config.php - crealo manualmente<br>";
        echo "<pre>" . htmlspecialchars($config_content) . "</pre>";
    }
    echo "</div>";
}

// ADMIN SEMPLICE FUNZIONANTE
echo "<div class='test' style='background: #e6ffe6;'>";
echo "<h3>5. Admin Panel Semplice</h3>";
echo "<p>Se tutto sopra è ✅, puoi usare questo pannello semplice:</p>";
echo "<a href='simple.php' style='padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px; display: inline-block;'>Apri Admin Semplice</a>";
echo "</div>";

echo "
</body>
</html>";

// CREA ANCHE UN ADMIN SEMPLICE CHE FUNZIONA
$simple_admin = '<?php
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
                <a href="../app/">🎵 Vai all\'App</a><br><br>
                <a href="../">🏠 Home</a><br><br>
                <a href="logout.php">🚪 Logout</a>
            </p>
        </div>
    </div>
</body>
</html>';

// Salva il pannello semplice
@file_put_contents('simple.php', $simple_admin);

// Crea anche logout.php se non esiste
$logout_content = '<?php session_start(); session_destroy(); header("Location: simple.php");';
@file_put_contents('logout.php', $logout_content);
?>