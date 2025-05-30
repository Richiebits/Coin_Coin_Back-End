<?php

class depenseController {
    public static function getDepenses($budgetId) {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        //Vérification du token et obtention de l'id de l'utilisateur
        try{
            $userid = verifyToken();
        } catch(Exception $e){
            $response = [];
            http_response_code(401);
            $response['error'] = "Non autorisé : " . $e;
            echo json_encode($response);
            return;
        }


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

        if (!headerIsSet('Access-Control-Allow-Origin') && !headerIsSet('Content-Type: application/json; charset=utf-8')) {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=utf-8");
        }

         //Vérification du token et obtention de l'id de l'utilisateur
        try{
            $userid = verifyToken();
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(["error" => "Non autorisé : " . $e]);
            return;
        }
    
        $data = json_decode(file_get_contents('php://input'), true);
    
        try {
            $stmt = $pdo->prepare("SELECT id FROM Budget ORDER BY id DESC LIMIT 1");
            $stmt->execute();
            $budget = $stmt->fetch();
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
            return;
        }
    
        try {
            $stmt = $pdo->prepare("INSERT INTO Retrait (nom, montant, retrait_recurrence, budget_id) 
                VALUES (:nom, :montant, :retrait_recurrence, :budget_id)");
            $stmt->execute([
                ':nom' => $data['nomRetrait'],
                ':montant' => $data['montantRetrait'],
                ':retrait_recurrence' => $data['retrait_recurrence'],
                ':budget_id' => isset($data['id']) ? $data['id'] : $budget['id']
            ]);
    
            historiqueController::addHistorique($data['retrait_recurrence'], 'retrait');
    
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
    
    public static function updateDepense($id) {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");
        
        //Vérification du token et obtention de l'id de l'utilisateur
        try{
            $userid = verifyToken();
        } catch(Exception $e){
            $response = [];
            http_response_code(401);
            $response['error'] = "Non autorisé : " . $e;
            echo json_encode($response);
            return;
        }


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