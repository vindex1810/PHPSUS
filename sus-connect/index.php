<?php
session_start();
require_once __DIR__ . '/includes/auth.php';

if (isset($_COOKIE['session_token'])) {
    $auth = new Auth();
    if ($auth->validateSession($_COOKIE['session_token'])) {
        header('Location: /dashboard.php');
        exit();
    }
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $auth = new Auth();
    $result = $auth->login($email, $password);

    if ($result['success']) {
        setcookie('session_token', $result['session_token'], time() + 86400, '/');
        header('Location: /dashboard.php');
        exit();
    } else {
        $error = $result['message'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUS Connect - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen relative text-white flex items-center justify-center">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('/assets/profissionais-saude.jpg')">
        <div class="absolute inset-0 bg-blue-900/70 backdrop-blur-[0.5px]"></div>
    </div>

    <div class="relative z-10 w-full max-w-md px-4">
        <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl border border-white/20 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-8 text-center">
                <img src="/assets/prefeitura_negativo.png" alt="Prefeitura de Dourados" class="h-16 w-auto mx-auto mb-4">
                <h1 class="text-3xl font-bold mb-2">SUS Connect</h1>
                <p class="text-blue-100 text-sm">Sistema de Monitoramento da Saúde</p>
            </div>

            <form method="POST" class="p-8 space-y-6">
                <?php if ($error): ?>
                <div class="bg-red-500/20 border border-red-500/50 rounded-lg p-3 flex items-start space-x-2">
                    <svg class="text-red-300 flex-shrink-0 mt-0.5" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="text-red-100 text-sm"><?php echo htmlspecialchars($error); ?></p>
                </div>
                <?php endif; ?>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-white">Email</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-blue-300" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <input type="email" name="email" required class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all text-white placeholder-blue-200" placeholder="Digite seu email">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-white">Senha</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-blue-300" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input type="password" name="password" required class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all text-white placeholder-blue-200" placeholder="Digite sua senha">
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-700 text-white py-3 rounded-lg font-medium hover:from-blue-600 hover:to-blue-800 transition-all transform hover:scale-[1.02]">
                    Entrar no Sistema
                </button>
            </form>

            <div class="px-8 pb-8 text-center text-xs text-blue-200">
                Sistema de Monitoramento da Saúde - Dourados/MS
            </div>
        </div>
    </div>
</body>
</html>
