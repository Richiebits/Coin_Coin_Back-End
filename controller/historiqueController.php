<?php

class historiqueController {
    public static function getHistorique($projetId) {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        try {
            $stmt = $pdo->prepare("SELECT * FROM Historique WHERE projet_id=:projet_id");
            $stmt->execute([':projet_id' => $projetId]);
            $historique = $stmt->fetch();
            echo json_encode($historique);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }

    public static function addHistorique() {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        
    }
}
?>