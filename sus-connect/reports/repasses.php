<?php
session_start();
require_once __DIR__ . '/../includes/auth.php';

$auth = new Auth();
$user = $auth->requireAuth();

$reportUrl = 'https://app.powerbi.com/view?r=eyJrIjoiNzRmODJmZDEtYzFkZS00MjkyLWEwMDYtNzRhNzJiMjAxZWMwIiwidCI6IjVkOGE4N2Q5LTZkODAtNDM5My05ZjNkLTUyOWE3MjU1MmQ3ZiJ9';
$reportTitle = 'Repasses Financeiros';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($reportTitle); ?> - SUS Connect</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-gray-900 flex flex-col">
    <header class="bg-blue-900 text-white shadow-lg z-10 flex-shrink-0">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="/dashboard.php" class="flex items-center space-x-2 hover:text-blue-200 transition-colors">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Voltar</span>
                    </a>
                    <div class="w-px h-6 bg-blue-700"></div>
                    <h1 class="text-xl font-bold"><?php echo htmlspecialchars($reportTitle); ?></h1>
                </div>
            </div>
        </div>
    </header>

    <div class="flex-1 flex flex-col min-h-0">
        <div id="loading" class="flex-1 flex items-center justify-center bg-gray-900">
            <div class="text-center">
                <div class="w-12 h-12 border-4 border-blue-500/30 border-t-blue-500 rounded-full animate-spin mx-auto mb-4"></div>
                <p class="text-white text-lg">Carregando relatório Power BI...</p>
            </div>
        </div>

        <div id="error" class="hidden flex-1 flex items-center justify-center bg-gray-900">
            <div class="text-center max-w-md mx-auto px-6">
                <svg class="w-12 h-12 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-white text-lg mb-4">Erro ao carregar o relatório</p>
                <a href="/dashboard.php" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors inline-block">
                    Voltar
                </a>
            </div>
        </div>

        <iframe
            id="powerbi-iframe"
            src="<?php echo htmlspecialchars($reportUrl); ?>"
            class="w-full h-full border-0 hidden"
            allowfullscreen
            title="Relatório Power BI - <?php echo htmlspecialchars($reportTitle); ?>"
            sandbox="allow-scripts allow-same-origin allow-forms allow-popups"
        ></iframe>
    </div>

    <script>
        const iframe = document.getElementById('powerbi-iframe');
        const loading = document.getElementById('loading');
        const error = document.getElementById('error');

        iframe.addEventListener('load', function() {
            console.log('Power BI carregado com sucesso!');
            loading.classList.add('hidden');
            iframe.classList.remove('hidden');
        });

        iframe.addEventListener('error', function() {
            console.error('Erro ao carregar Power BI');
            loading.classList.add('hidden');
            error.classList.remove('hidden');
        });
    </script>
</body>
</html>
