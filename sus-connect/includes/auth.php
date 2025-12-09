<?php
require_once __DIR__ . '/../config/Database.php';

class Auth {
    private $conn;
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function login($email, $password) {
        $query = "SELECT id, email, password_hash, name FROM users WHERE email = :email AND is_active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $user['password_hash'])) {
                $session_token = bin2hex(random_bytes(32));
                $expires_at = date('Y-m-d H:i:s', strtotime('+24 hours'));

                $query = "INSERT INTO sessions (user_id, session_token, expires_at) VALUES (:user_id, :token, :expires)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':user_id', $user['id']);
                $stmt->bindParam(':token', $session_token);
                $stmt->bindParam(':expires', $expires_at);
                $stmt->execute();

                $query = "UPDATE users SET last_login = NOW() WHERE id = :id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':id', $user['id']);
                $stmt->execute();

                $this->logAccess($user['id'], 'login');

                return [
                    'success' => true,
                    'session_token' => $session_token,
                    'user' => [
                        'email' => $user['email'],
                        'name' => $user['name']
                    ]
                ];
            }
        }

        return ['success' => false, 'message' => 'Credenciais inválidas'];
    }

    public function validateSession($session_token) {
        $query = "SELECT s.user_id, s.expires_at, u.email, u.name
                  FROM sessions s
                  JOIN users u ON s.user_id = u.id
                  WHERE s.session_token = :token AND s.expires_at > NOW() AND u.is_active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':token', $session_token);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }

    public function logout($session_token) {
        $query = "DELETE FROM sessions WHERE session_token = :token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':token', $session_token);
        return $stmt->execute();
    }

    public function requireAuth() {
        if (!isset($_COOKIE['session_token'])) {
            header('Location: /login.php');
            exit();
        }

        $user = $this->validateSession($_COOKIE['session_token']);
        if (!$user) {
            setcookie('session_token', '', time() - 3600, '/');
            header('Location: /login.php');
            exit();
        }

        return $user;
    }

    private function logAccess($user_id, $action) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;

        $query = "INSERT INTO access_logs (user_id, action, ip_address, user_agent) VALUES (:user_id, :action, :ip, :user_agent)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':action', $action);
        $stmt->bindParam(':ip', $ip);
        $stmt->bindParam(':user_agent', $user_agent);
        $stmt->execute();
    }
}
?>
