<?php
class Database {
    private $host = 'localhost';
    private $port = '3306';  // MySQL usa porta 3306
    private $db_name = 'sus-connect';
    private $username = 'root';
    private $password = '';  // XAMPP padrão é senha vazia
    private $conn;

    public function __construct() {
        // Para XAMPP com MySQL
        $this->host = 'localhost';
        $this->port = '3306';
        $this->db_name = 'sus-connect';
        $this->username = 'root';
        $this->password = '';
    }

    public function getConnection() {
        $this->conn = null;
        try {
            // Conexão MySQL (não PostgreSQL)
            $this->conn = new PDO(
                "mysql:host={$this->host};port={$this->port};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("SET NAMES 'utf8'");
            
        } catch(PDOException $e) {
            error_log("Erro de conexão MySQL: " . $e->getMessage());
            throw new Exception("Erro ao conectar com o banco de dados MySQL");
        }
        return $this->conn;
    }
}

// Configurações do Supabase
define('SUPABASE_URL', 'https://yimjmqkwlptdaswljgty.supabase.co');
define('SUPABASE_ANON_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InlpbWptcWt3bHB0ZGFzd2xqZ3R5Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjE2NDIzODUsImV4cCI6MjA3NzIxODM4NX0.-HUszPLVM-je0fWqjkPMgx_whbQxHuheyR9RGo8ocH0');

// Função para debug
function testDatabaseConnection() {
    try {
        $db = new Database();
        $conn = $db->getConnection();
        return "✅ Conexão MySQL OK!";
    } catch (Exception $e) {
        return "❌ Erro: " . $e->getMessage();
    }
}

// =============================================
// FUNÇÕES DE AUTENTICAÇÃO (ADICIONAR AGORA)
// =============================================

/**
 * Verifica se o usuário está logado
 */
function isLoggedIn() {
    // Para teste, vamos usar sessão simples
    session_start();
    return isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true;
}

/**
 * Função de login simples para teste
 */
function fazerLogin($username, $password) {
    // Credenciais de teste - depois substitua por verificação no banco
    $usuarios_validos = [
        'admin' => '123456',
        'sems' => 'sems2024',
        'usuario' => 'senha123'
    ];
    
    if (isset($usuarios_validos[$username]) && $usuarios_validos[$username] === $password) {
        session_start();
        $_SESSION['usuario_logado'] = true;
        $_SESSION['nome_usuario'] = $username;
        return true;
    }
    
    return false;
}

/**
 * Função de logout
 */
function fazerLogout() {
    session_start();
    session_destroy();
    header('Location: ./index.php');
    exit;
}

/**
 * Verifica login e redireciona se não estiver logado
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: index.php?login=true');
        exit;
    }
}
?>