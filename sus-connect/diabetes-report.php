<?php
require_once 'config.php';
requireLogin();

$selectedYear = isset($_GET['year']) ? $_GET['year'] : '2025';
$selectedUnit = isset($_GET['unit']) ? $_GET['unit'] : 'Dourados';
$selectedTeam = isset($_GET['team']) ? $_GET['team'] : '';
$minAge = isset($_GET['min_age']) ? $_GET['min_age'] : '';
$maxAge = isset($_GET['max_age']) ? $_GET['max_age'] : '';
$filterStatus = isset($_GET['status']) ? $_GET['status'] : 'Válidos';

$metrics = [
    ['label' => '% com hemoglobina glicada válida', 'value' => 'xx%'],
    ['label' => '% pacientes avaliados', 'value' => 'xx%'],
    ['label' => '% com PA aferida', 'value' => 'xx%'],
    ['label' => '% Visita ACS', 'value' => 'xx%'],
    ['label' => '% Antropometria', 'value' => 'xx%'],
    ['label' => 'Nota ESF %', 'value' => 'xx%', 'highlight' => true]
];

$teamData = [
    ['team' => 'ESF 39', 'percentage' => 94, 'color' => 'bg-blue-500'],
    ['team' => 'ESF 27', 'percentage' => 89, 'color' => 'bg-blue-400'],
    ['team' => 'ESF 58', 'percentage' => 87, 'color' => 'bg-blue-400'],
    ['team' => 'ESF 17', 'percentage' => 74, 'color' => 'bg-green-500'],
    ['team' => 'ESF 40', 'percentage' => 42, 'color' => 'bg-yellow-500'],
    ['team' => 'ESF 39', 'percentage' => 21, 'color' => 'bg-red-500']
];

$patients = [
    [
        'name' => 'AIDA RAMONA FERREIRA DA COSTA',
        'cpf' => '53231892134',
        'cns' => '708089757311',
        'age' => 79,
        'team' => 'Clínico',
        'esf' => '39',
        'visitaAcs' => false,
        'antropometria' => true,
        'paValida' => true,
        'classification' => 'Suficiente',
        'whatsapp' => true
    ],
    [
        'name' => 'AIDIA PINHEIRO DA SILVA',
        'cpf' => '0358424719',
        'cns' => '708022535165',
        'age' => 85,
        'team' => 'Clínico',
        'esf' => '39',
        'visitaAcs' => true,
        'antropometria' => true,
        'paValida' => false,
        'classification' => 'Regular',
        'whatsapp' => true
    ],
    [
        'name' => 'DIAS ALVES DA SILVA FILHO',
        'cpf' => '0112841941',
        'cns' => '708014467253',
        'age' => 39,
        'team' => 'Clínico',
        'esf' => '39',
        'visitaAcs' => true,
        'antropometria' => true,
        'paValida' => false,
        'classification' => 'Bom',
        'whatsapp' => true
    ],
    [
        'name' => 'DIAS FIRMINO DA SILVA',
        'cpf' => '05377827891',
        'cns' => '008040478997',
        'age' => 85,
        'team' => 'Clínico',
        'esf' => '39',
        'visitaAcs' => true,
        'antropometria' => false,
        'paValida' => true,
        'classification' => 'Ótimo',
        'whatsapp' => true
    ],
    [
        'name' => 'AIDAI RAMONA FERREIRA DA COSTA',
        'cpf' => '51202131269',
        'cns' => '73318981',
        'age' => 39,
        'team' => 'Clínico',
        'esf' => '30',
        'visitaAcs' => true,
        'antropometria' => true,
        'paValida' => true,
        'classification' => 'Ótimo',
        'whatsapp' => false
    ]
];

function getClassificationColor($classification) {
    switch ($classification) {
        case 'Regular': return 'bg-red-500 text-white';
        case 'Suficiente': return 'bg-yellow-500 text-white';
        case 'Bom': return 'bg-green-500 text-white';
        case 'Ótimo': return 'bg-blue-500 text-white';
        default: return 'bg-gray-500 text-white';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerencial Consolidado - Diabéticos - SUS Connect</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="assets/css/diabetes.css">
</head>
<body>
    <div class="min-h-screen bg-gray-50">
        <header class="dashboard-header">
            <div class="container px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="dashboard.php" class="flex items-center space-x-2 hover:text-blue-200 transition-colors">
                            <svg class="svg-icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span>Voltar</span>
                        </a>
                        <h1 class="text-2xl font-bold">Gerencial Consolidado - Diabéticos</h1>
                    </div>
                </div>
            </div>
        </header>

        <div class="container px-6 py-8">
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    <div>
                        <label class="form-label">Período</label>
                        <select class="form-select">
                            <option value="2025" <?php echo $selectedYear === '2025' ? 'selected' : ''; ?>>2025</option>
                            <option value="2024" <?php echo $selectedYear === '2024' ? 'selected' : ''; ?>>2024</option>
                            <option value="2023" <?php echo $selectedYear === '2023' ? 'selected' : ''; ?>>2023</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Unidade</label>
                        <select class="form-select">
                            <option value="Dourados">Dourados</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Equipe</label>
                        <select class="form-select">
                            <option value="">Todas</option>
                            <option value="39">ESF 39</option>
                            <option value="27">ESF 27</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Idade Mínima</label>
                        <input type="number" class="form-select" placeholder="Min">
                    </div>
                    <div>
                        <label class="form-label">Idade Máxima</label>
                        <input type="number" class="form-select" placeholder="Max">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
                <?php foreach ($metrics as $metric): ?>
                    <div class="<?php echo isset($metric['highlight']) ? 'metric-highlight' : 'metric-card'; ?>">
                        <div class="metric-value"><?php echo $metric['value']; ?></div>
                        <div class="metric-label"><?php echo $metric['label']; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <div class="lg-col-span-2 bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Classificação por equipe</h3>
                    <div class="space-y-3">
                        <?php foreach ($teamData as $team): ?>
                            <div class="flex items-center space-x-3">
                                <div class="team-name"><?php echo $team['team']; ?></div>
                                <div class="team-bar-bg">
                                    <div class="team-bar <?php echo $team['color']; ?>" style="width: <?php echo $team['percentage']; ?>%">
                                        <span class="team-bar-label"><?php echo $team['percentage']; ?>%</span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="svg-icon-sm" style="margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Mapa
                    </h3>
                    <div class="map-container">
                        <div class="map-gradient">
                            <div class="map-pin" style="top: 25%; left: 33%;"></div>
                            <div class="map-pin" style="top: 33%; left: 50%;"></div>
                            <div class="map-pin" style="top: 50%; left: 25%;"></div>
                            <div class="map-pin" style="top: 66%; left: 66%;"></div>
                            <div class="map-pin" style="bottom: 25%; right: 33%;"></div>
                            <div class="map-label">Jardim Guaicurus</div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="legend-grid">
                            <div class="legend-item">
                                <div class="legend-badge" style="background-color: #3b82f6;">7,25</div>
                                <div class="legend-text">NOTA DA ESF</div>
                            </div>
                            <div class="legend-item">
                                <div class="legend-badge" style="background-color: #22c55e;">Bom</div>
                            </div>
                        </div>

                        <div class="legend-labels">
                            <span>Regular</span>
                            <span>Suficiente</span>
                            <span>Bom</span>
                            <span>Ótimo</span>
                        </div>
                        <div class="legend-bar">
                            <div class="legend-bar-item" style="background-color: #f87171;"></div>
                            <div class="legend-bar-item" style="background-color: #fbbf24;"></div>
                            <div class="legend-bar-item" style="background-color: #4ade80;"></div>
                            <div class="legend-bar-item" style="background-color: #60a5fa;"></div>
                        </div>
                        <div class="legend-values">
                            <span>&lt; 25%</span>
                            <span>&gt; 50%</span>
                            <span>&gt; 75%</span>
                            <span>&gt; 100%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-4 mb-6">
                <button class="btn-export btn-blue">
                    <svg class="svg-icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>NOTA TÉCNICA</span>
                </button>
                <button class="btn-export btn-green">
                    <svg class="svg-icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    <span>EXPORTAR CSV</span>
                </button>
                <button class="btn-export btn-emerald">
                    <svg class="svg-icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    <span>EXPORTAR EXCEL</span>
                </button>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="table-header">
                    <h3 class="text-lg font-semibold">Lista de Pacientes</h3>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <select class="form-select" style="width: auto;">
                            <option value="Válidos">Válidos</option>
                            <option value="Todos">Todos</option>
                        </select>
                    </div>

                    <div class="table-wrapper">
                        <table class="patient-table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>CNS</th>
                                    <th>Idade</th>
                                    <th>ESF</th>
                                    <th>Visita ACS</th>
                                    <th>Antropometria</th>
                                    <th>P.A Válida</th>
                                    <th>Pontuação</th>
                                    <th>Classificação</th>
                                    <th>WhatsApp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($patients as $patient): ?>
                                    <tr>
                                        <td class="patient-name"><?php echo htmlspecialchars($patient['name']); ?></td>
                                        <td><?php echo htmlspecialchars($patient['cpf']); ?></td>
                                        <td><?php echo htmlspecialchars($patient['cns']); ?></td>
                                        <td><?php echo $patient['age']; ?></td>
                                        <td><?php echo htmlspecialchars($patient['esf']); ?></td>
                                        <td>
                                            <?php if ($patient['visitaAcs']): ?>
                                                <svg class="icon-check" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            <?php else: ?>
                                                <svg class="icon-x" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($patient['antropometria']): ?>
                                                <svg class="icon-check" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            <?php else: ?>
                                                <svg class="icon-x" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($patient['paValida']): ?>
                                                <svg class="icon-check" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            <?php else: ?>
                                                <svg class="icon-x" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            <?php endif; ?>
                                        </td>
                                        <td>-</td>
                                        <td>
                                            <span class="classification-badge <?php echo getClassificationColor($patient['classification']); ?>">
                                                <?php echo $patient['classification']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($patient['whatsapp']): ?>
                                                <div class="whatsapp-badge">W</div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
