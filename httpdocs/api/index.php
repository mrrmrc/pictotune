<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    exit(0);
}

require_once "config.php";

// Router semplice
$route = $_GET["route"] ?? "";
$method = $_SERVER["REQUEST_METHOD"];
$input = json_decode(file_get_contents("php://input"), true);

// Database connection
try {
    $db = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

// Routes
switch ($route) {
    case "health":
        echo json_encode([
            "status" => "ok",
            "site" => SITE_NAME,
            "version" => "1.0.0"
        ]);
        break;
        
    case "auth/login":
        if ($method !== "POST") {
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed"]);
            break;
        }
        
        $email = $input["email"] ?? "";
        $password = $input["password"] ?? "";
        
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user["password"])) {
            $token = bin2hex(random_bytes(32));
            $expires = date("Y-m-d H:i:s", strtotime("+7 days"));
            
            $stmt = $db->prepare("INSERT INTO user_sessions (user_id, token, expires_at) VALUES (?, ?, ?)");
            $stmt->execute([$user["id"], $token, $expires]);
            
            echo json_encode([
                "success" => true,
                "token" => $token,
                "user" => [
                    "id" => $user["id"],
                    "email" => $user["email"],
                    "username" => $user["username"],
                    "credits" => $user["credits"]
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(["error" => "Invalid credentials"]);
        }
        break;
        
    case "auth/register":
        if ($method !== "POST") {
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed"]);
            break;
        }
        
        $email = $input["email"] ?? "";
        $username = $input["username"] ?? "";
        $password = $input["password"] ?? "";
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid input"]);
            break;
        }
        
        try {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
            $stmt->execute([$email, $username, $hashed]);
            
            echo json_encode([
                "success" => true,
                "message" => "Registration successful"
            ]);
        } catch (PDOException $e) {
            http_response_code(409);
            echo json_encode(["error" => "Email or username already exists"]);
        }
        break;
        
    default:
        http_response_code(404);
        echo json_encode(["error" => "Endpoint not found"]);
}
