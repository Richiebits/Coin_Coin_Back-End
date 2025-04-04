<?php

class depenseController {
    public static function getDepenses($budgetId) {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        try {
            $stmt = $pdo->prepare("SELECT * FROM Retrait WHERE budget_id=:budget_id");
            $stmt->execute([':budget_id' => $budgetId]);
            $depenses = $stmt->fetchAll();
            echo json_encode($depenses);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
    public static function addDepense() {
        global $pdo;

         header("Access-Control-Allow-Origin: *");
         header("Content-Type: application/json; charset=utf-8");
 
         $data = json_decode(file_get_contents('php://input'), true);

         try {
            $stmt = $pdo->prepare("SELECT id FROM Budget ORDER BY id DESC LIMIT 1");
            $stmt->execute();
            $budget = $stmt->fetch();
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
 
         //Dans l'execute, vérifie si les variables existent. 
         try {
            $stmt = $pdo->prepare("INSERT INTO Retrait (nom, montant, retrait_recurrence, budget_id) VALUES (:nom, :montant, :retrait_recurrence, :budget_id)");
            $stmt->execute([
                ':nom' => $data['nomRetrait'],
                ':montant' => $data['montantRetrait'],
                ':retrait_recurrence' => $data['retrait_recurrence'],
                ':budget_id' => $budget['id']
            ]);
         } catch(PDOException $e) {
             http_response_code(500);
             echo json_encode(array("error"=> $e->getMessage()));
         }
    }
    public static function updateDepense($id) {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        $data = json_decode(file_get_contents('php://input'), true);
        
        try {
            $stmt = $pdo->prepare("UPDATE Retrait SET 
                nom = :nom,
                montant = :montant
                WHERE id_depense = :id_depense"
            );
            $stmt->execute([
                ':nom' => $data['nom'],
                ':montant' => $data['montant'],
                ':id_depense' => $id
            ]);
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
}
?>