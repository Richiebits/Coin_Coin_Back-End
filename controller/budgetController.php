<?php

class budgetController {
    
    public static function getBudget($id) {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        try {
            $stmt = $pdo->prepare("SELECT * FROM Budget WHERE id=:id");
            $stmt->execute([':id' => $id]);
            $projet = $stmt->fetchAll();
            echo json_encode($projet);
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
 
         try {
             //À compléter
             echo json_encode(['success' => true, 'message' => 'Budget créé avec succès']);
         } catch(PDOException $e) {
             http_response_code(500);
             echo json_encode(array("error"=> $e->getMessage()));
         }
    }
    public static function updateBudget($id) {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        $data = json_decode(file_get_contents('php://input'), true);

        try {
            //À compléter
            echo json_encode(['success' => true, 'message' => 'Budget modifié avec succès']);
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
}
?>