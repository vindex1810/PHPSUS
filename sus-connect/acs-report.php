<?php
// acs-report.php
require_once 'config.php';
require_once 'models/RelatorioModel.php';

$model = new RelatorioModel();
$unidades = $model->getUnidades();

// Processar filtros se formulário foi enviado
$filtros = [];
if ($_POST) {
    $filtros = [
        'unidade_id' => $_POST['unidade_id'] ?? '',
        'equipe_id' => $_POST['equipe_id'] ?? '',
        'profissional_id' => $_POST['profissional_id'] ?? ''
    ];
    
    // Buscar dados filtrados
    $dados = $model->gerarRelatorioACS($filtros);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de ACS - SUS Connect</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Relatório de Agentes Comunitários de Saúde</h1>
        
        <form method="POST" class="filtros-form">
            <div class="filtro-group">
                <label>Unidade:</label>
                <select name="unidade_id" id="unidade_id">
                    <option value="">Todas as unidades</option>
                    <?php foreach($unidades as $unidade): ?>
                        <option value="<?= $unidade['id'] ?>" <?= ($filtros['unidade_id'] ?? '') == $unidade['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($unidade['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="filtro-group">
                <label>Equipe:</label>
                <select name="equipe_id" id="equipe_id" <?= empty($filtros['unidade_id']) ? 'disabled' : '' ?>>
                    <option value="">Todas as equipes</option>
                </select>
            </div>
            
            <div class="filtro-group">
                <label>Profissional:</label>
                <select name="profissional_id" id="profissional_id" <?= empty($filtros['equipe_id']) ? 'disabled' : '' ?>>
                    <option value="">Todos os profissionais</option>
                </select>
            </div>
            
            <button type="submit">Filtrar</button>
            <?php if(isset($dados) && !empty($dados)): ?>
                <button type="button" onclick="exportarCSV()">Exportar CSV</button>
            <?php endif; ?>
        </form>
        
        <?php if(isset($dados)): ?>
            <div class="resultados">
                <h3>Resultados (<?= count($dados) ?> registros)</h3>
                <?php if(empty($dados)): ?>
                    <p>Nenhum dado encontrado com os filtros selecionados.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Unidade</th>
                                <th>Equipe</th>
                                <th>Profissional</th>
                                <th>CNS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dados as $linha): ?>
                                <tr>
                                    <td><?= htmlspecialchars($linha['unidade']) ?></td>
                                    <td><?= htmlspecialchars($linha['equipe']) ?></td>
                                    <td><?= htmlspecialchars($linha['profissional']) ?></td>
                                    <td><?= htmlspecialchars($linha['matricula']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
