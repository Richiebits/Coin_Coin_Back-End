<?php

class historiqueController {
    public static function getHistorique($projetId) {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        try {
            $stmt = $pdo->prepare("SELECT * FROM Historique WHERE projet_id=:projet_id");
            $stmt->execute([':projet_id' => $projetId]);
            $historique = $stmt->fetchAll();
            echo json_encode($historique);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
    public static function getHistoriqueSelonClient($id){
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        try {
            $stmt = $pdo->prepare("SELECT * FROM Historique WHERE client_id=:client_id");
            $stmt->execute([':client_id' => $id]);
            $historique = $stmt->fetchAll();
            echo json_encode($historique);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
    
    public static function addHistorique($recurrence, $type = "") {
        global $pdo;
        
        if (!headerIsSet('Access-Control-Allow-Origin') && !headerIsSet('Content-Type: application/json; charset=utf-8')) {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=utf-8");
        }
    
        // Vérification du token
        try{
            $userid = verifyToken();
        } catch(Exception $e){
            $response = [];
            http_response_code(401);
            $response['error'] = "Non autorisé : " . $e;
            echo json_encode($response);
            return;
        }
    
        // Lecture des données JSON
        $data = json_decode(file_get_contents("php://input"), true);
    
        // Vérification du type
        if (isset($data['type']) && !in_array($data['type'], ['depot', 'retrait', 'création projet'])) {
            http_response_code(400);
            echo json_encode(["error" => "Type invalide"]);
            return;
        }
        
        // Obtention du projet_id s'il n'est pas mis dans le body
        if (!isset($data['projet_id'])) {
            try {
                $stmt = $pdo->prepare("SELECT id FROM Projet WHERE client_id=:client_id ORDER BY id DESC LIMIT 1");
                $stmt->execute([':client_id'=> $data['client_id']]);
                $projet = $stmt->fetch();
            } catch(PDOException $e) {
                http_response_code(500);
                echo json_encode(array("error"=> $e->getMessage()));
            }
        }
        
        $montant = 0;
        if (!isset($data['montant'])) {
            $montant = $type == 'depot' ? $data['montantDepot'] : $data['montantRetrait'];
        } else {
            $montant = $data['montant'];
        }
        try {
            $stmt = $pdo->prepare("INSERT INTO Historique (projet_id, client_id, type, montant, recurrence) VALUES (:projet_id, :client_id, :type, :montant, :recurrence)");
            $stmt->execute([
                ':projet_id' => isset($data['projet_id']) ? $data['projet_id'] : $projet["id"],
                ':client_id' => $userid,
                ':type' => isset($data['type']) ? $data['type'] : $type,
                ':montant' => $montant,
                ':recurrence' => $recurrence
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