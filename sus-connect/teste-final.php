<?php
// teste-final.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Teste Final - SUS Connect</h1>";

// Testar se config.php carrega
try {
    require_once 'config.php';
    echo "✅ config.php carregado<br>";
} catch (Exception $e) {
    echo "❌ Erro no config.php: " . $e->getMessage() . "<br>";
}

// Testar Database
try {
    $db = new Database();
    $conn = $db->getConnection();
    echo "✅ Database conectado<br>";
} catch (Exception $e) {
    echo "❌ Erro Database: " . $e->getMessage() . "<br>";
}

// Testar RelatorioModel
try {
    require_once 'models/RelatorioModel.php';
    $model = new RelatorioModel();
    echo "✅ RelatorioModel carregado<br>";
    
    $unidades = $model->getUnidades();
    echo "✅ Unidades: " . count($unidades) . " encontradas<br>";
    
} catch (Exception $e) {
    echo "❌ Erro RelatorioModel: " . $e->getMessage() . "<br>";
}
?>