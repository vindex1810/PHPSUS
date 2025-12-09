<?php
// models/RelatorioModel.php - CORRIGIDO

// USE ESTE CAMINHO (remove o ../):
require_once 'config.php';

class RelatorioModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Buscar todas as unidades
    public function getUnidades() {
        try {
            $query = "SELECT DISTINCT 
                         co_seq_dim_unidade_saude as id, 
                         no_unidade_saude as nome 
                      FROM tb_dim_unidade_saude 
                      WHERE st_registro_valido = 1
                      ORDER BY no_unidade_saude";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar unidades: " . $e->getMessage());
            return [];
        }
    }

    // Buscar equipes por unidade
    public function getEquipesByUnidade($unidade_id) {
        try {
            $query = "SELECT 
                         co_seq_dim_equipe as id, 
                         no_equipe as nome 
                      FROM tb_dim_equipe 
                      WHERE co_seq_dim_unidade_saude = :unidade_id 
                      AND st_registro_valido = 1
                      ORDER BY no_equipe";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':unidade_id', $unidade_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar equipes: " . $e->getMessage());
            return [];
        }
    }

    // Buscar profissionais por equipe
    public function getProfissionaisByEquipe($equipe_id) {
        try {
            $query = "SELECT 
                         co_seq_dim_profissional as id, 
                         no_profissional as nome,
                         nu_cns as matricula
                      FROM tb_dim_profissional 
                      WHERE co_seq_dim_equipe = :equipe_id 
                      AND st_registro_valido = 1
                      ORDER BY no_profissional";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':equipe_id', $equipe_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar profissionais: " . $e->getMessage());
            return [];
        }
    }

    // Gerar relatório com filtros
    public function gerarRelatorioACS($filtros) {
        try {
            $query = "SELECT 
                         u.no_unidade_saude as unidade,
                         e.no_equipe as equipe,
                         p.no_profissional as profissional,
                         p.nu_cns as matricula
                      FROM tb_dim_profissional p
                      INNER JOIN tb_dim_equipe e ON p.co_seq_dim_equipe = e.co_seq_dim_equipe
                      INNER JOIN tb_dim_unidade_saude u ON e.co_seq_dim_unidade_saude = u.co_seq_dim_unidade_saude
                      WHERE u.st_registro_valido = 1 
                      AND e.st_registro_valido = 1 
                      AND p.st_registro_valido = 1";
            
            $params = [];

            if (!empty($filtros['unidade_id'])) {
                $query .= " AND u.co_seq_dim_unidade_saude = :unidade_id";
                $params[':unidade_id'] = $filtros['unidade_id'];
            }

            if (!empty($filtros['equipe_id'])) {
                $query .= " AND e.co_seq_dim_equipe = :equipe_id";
                $params[':equipe_id'] = $filtros['equipe_id'];
            }

            if (!empty($filtros['profissional_id'])) {
                $query .= " AND p.co_seq_dim_profissional = :profissional_id";
                $params[':profissional_id'] = $filtros['profissional_id'];
            }

            $query .= " ORDER BY u.no_unidade_saude, e.no_equipe, p.no_profissional";

            $stmt = $this->conn->prepare($query);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro ao gerar relatório: " . $e->getMessage());
            throw new Exception("Erro ao buscar dados do relatório");
        }
    }
}
?>