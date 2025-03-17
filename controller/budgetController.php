<?php

class budgetController {
    
    public static function getBudget($projetId) {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        try {
            $stmt = $pdo->prepare("SELECT * FROM Budget WHERE projet_id=:projet_id");
            $stmt->execute([':projet_id' => $projetId]);
            $budget = $stmt->fetchAll();
            echo json_encode($budget);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
    public static function addBudget() {
         global $pdo;

         header("Access-Control-Allow-Origin: *");
         header("Content-Type: application/json; charset=utf-8");
 
         $data = json_decode(file_get_contents('php://input'), true);
 
         //Dans l'execute, vérifie si les variables existent. 
         try {
            $stmt = $pdo->prepare("INSERT INTO Budget (depenses_total, revenus_total, date_debut, date_fin, projet_id) VALUES (:depenses_total, :revenus_total, :date_debut, :date_fin, :projet_id)");
            $stmt->execute([
                ':depenses_total' => isset($data['depenses_total']) ? $data['depenses_total'] : null,
                ':revenus_total' => isset($data['revenus_total']) ? $data['revenus_total'] : null,
                ':date_debut' => isset($data['date_debut']) ? $data['date_debut'] : null,
                ':date_fin' => isset($data['date_fin']) ? $data['date_fin'] : null,
                ':projet_id' => isset($data['projet_id']) ? $data['projet_id'] : null
            ]);
         } catch(PDOException $e) {
             http_response_code(500);
             echo json_encode(array("error"=> $e->getMessage()));
         }
    }
    public static function updateBudget($projetId) {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        $data = json_decode(file_get_contents('php://input'), true);
        
        try {
            $stmt = $pdo->prepare("UPDATE Budget SET 
                depenses_total = :depenses_total,
                revenus_total = :revenus_total,
                date_debut = :date_debut,
                date_fin = :date_fin
                WHERE projet_id = :projet_id"
            );
            $stmt->execute([
                ':depenses_total' => $data['depenses_total'],
                ':revenus_total' => $data['revenus_total'],
                ':date_debut' => $data['date_debut'],
                ':date_fin' => $data['date_fin'],
                ':projet_id' => $projetId
            ]);
            echo json_encode(['success' => true, 'message' => 'Budget modifié avec succès']);
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
}
?>