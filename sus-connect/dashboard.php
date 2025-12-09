<?php
session_start();
require_once __DIR__ . '/includes/auth.php';

$auth = new Auth();
$user = $auth->requireAuth();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUS Connect</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen relative text-white">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('/assets/profissionais-saude.jpg')">
        <div class="absolute inset-0 bg-blue-900/70 backdrop-blur-[0.5px]"></div>
    </div>

    <div class="relative z-10">
        <header class="bg-blue-900/60 backdrop-blur-sm border-b border-blue-700/30">
            <div class="container mx-auto px-4 py-4">
                <nav class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="/assets/prefeitura_negativo.png" alt="Prefeitura de Dourados" class="h-12 w-auto">
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center space-x-2 text-blue-100">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm font-medium"><?php echo explode('@', htmlspecialchars($user['email']))[0]; ?></span>
                            </div>

                            <div class="w-px h-6 bg-blue-400/50"></div>

                            <a href="/logout.php" class="flex items-center space-x-2 bg-red-600/80 hover:bg-red-700/80 px-3 py-2 rounded-lg transition-colors duration-200 backdrop-blur-sm">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span class="text-sm font-medium text-white">Sair</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <main class="container mx-auto px-4 py-16">
            <div class="text-center mb-16">
                <h1 class="text-6xl md:text-8xl font-bold mb-6 bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">
                    SUS CONNECT
                </h1>
                <p class="text-xl md:text-2xl font-light text-blue-100 max-w-2xl mx-auto">
                    MONITORAMENTO DA SAÚDE EM DOURADOS/MS
                </p>
                <div class="mt-8 w-24 h-1 bg-gradient-to-r from-blue-400 to-cyan-400 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-16">
                <a href="/reports/atencao.php" class="group block">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl border border-white/20">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-blue-400 transition-colors">
                                <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-3 text-white">ATENÇÃO PRIMÁRIA</h3>
                            <div class="space-y-2 text-sm text-blue-100">
                                <p>Cuidados</p>
                                <p>Informações básicas</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="/reports/vigilancia.php" class="group block">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl border border-white/20">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-cyan-400 transition-colors">
                                <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-3 text-white">VIGILÂNCIA EM SAÚDE</h3>
                            <div class="space-y-2 text-sm text-blue-100">
                                <p>Servidor</p>
                                <p>Relatórios, Boletins</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="/reports/repasses.php" class="group block">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl border border-white/20">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-green-400 transition-colors">
                                <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-3 text-white">REPASSES FINANCEIROS</h3>
                            <div class="space-y-2 text-sm text-blue-100">
                                <p>Visualize os Dados</p>
                                <p>de Repasses Financeiros</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="https://arbonotifica.sems.dourados.ms.gov.br/app/auth/login/" target="_blank" rel="noopener noreferrer" class="group block">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl border border-white/20">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-orange-400 transition-colors">
                                <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-3 text-white">ARBOVIRÓSES</h3>
                            <div class="space-y-2 text-sm text-blue-100">
                                <p>Acesse o Sistema</p>
                                <p>Arbo Notifica Dourados</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold mb-2">Monitoramento em Tempo Real</h4>
                    <p class="text-blue-200 text-sm">Acompanhe indicadores de saúde da cidade de Dourados em tempo real</p>
                </div>

                <a href="https://drive.google.com/drive/folders/14VBRXCmS_pviSqblQ01VBtlhthwnae6P" target="_blank" class="text-center group cursor-pointer">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-200">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold mb-2 text-white">Mapas CCZ</h4>
                    <p class="text-blue-200 text-sm">Mapas territoriais por áreas específicas dos agentes de endemias</p>
                </a>

                <a href="https://www.google.com/maps/d/u/0/viewer?hl=pt-BR&mid=1aOdQQ9s9vBtyibgLy5cPTEMU2Oqq6mw&ll=-22.23198731693114%2C-54.83619882987065&z=13" target="_blank" class="text-center group cursor-pointer">
                    <div class="w-12 h-12 bg-gradient-to-r from-teal-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-200">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold mb-2 text-white">Mapa Territorial das UBSs</h4>
                    <p class="text-blue-200 text-sm">Acesse o mapa das Unidades Básicas de Saúde de Dourados</p>
                </a>
            </div>
        </main>

        <footer class="bg-blue-950/70 backdrop-blur-sm border-t border-blue-700/30 mt-20">
            <div class="container mx-auto px-4 py-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div class="flex items-start space-x-4 mb-4 md:mb-0">
                        <img src="/assets/sems-logo.png" alt="SEMS" class="h-12 w-auto">
                        <div class="text-left">
                            <p class="text-blue-200 text-sm">© 2025 SUS Connect - Sistema de Monitoramento da Saúde</p>
                            <p class="text-blue-300 text-xs mt-1">Prefeitura Municipal de Dourados/MS</p>
                        </div>
                    </div>

                    <div class="flex space-x-6 text-sm">
                        <a href="#" class="text-blue-200 hover:text-white transition-colors">Política de Privacidade</a>
                        <a href="#" class="text-blue-200 hover:text-white transition-colors">Termos de Uso</a>
                        <a href="#" class="text-blue-200 hover:text-white transition-colors">Contato</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
