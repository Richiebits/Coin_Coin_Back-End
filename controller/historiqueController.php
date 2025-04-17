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
    
        // Vérification du token
        try {
            $userid = verifyToken();
        } catch(Exception $e) {
            http_response_code(401);
            echo json_encode(["error" => "Non autorisé : " . $e->getMessage()]);
            return;
        }
    
        // Lecture des données JSON
        $data = json_decode(file_get_contents("php://input"), true);
    
        // Vérification des champs requis
        if (!isset($data['projet_id'], $data['date_histo'], $data['type'], $data['montant'])) {
            http_response_code(400);
            echo json_encode(["error" => "Données incomplètes"]);
            return;
        }
    
        // Vérification du type
        if (!in_array($data['type'], ['depot', 'retrait'])) {
            http_response_code(400);
            echo json_encode(["error" => "Type invalide"]);
            return;
        }
    
        try {
            // Insertion dans la table Historique
            $stmt = $pdo->prepare("INSERT INTO Historique (projet_id, date_histo, type, montant) VALUES (:projet_id, :date_histo, :type, :montant)");
            $stmt->execute([
                ':projet_id' => $data['projet_id'],
                ':date_histo' => $data['date_histo'],
                ':type' => $data['type'],
                ':montant' => $data['montant']
            ]);
    
            http_response_code(201);
            echo json_encode(["success" => true]);
    
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }    
}
?>