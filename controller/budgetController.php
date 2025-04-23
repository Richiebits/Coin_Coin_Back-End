<?php

//require "depenseController.php";
//require "revenuController.php";

class budgetController {
    
    public static function getBudget($projetId) {
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
 
         //Va chercher l'id du dernier projet de l'utilisateur (le nouveau projet)
         try {
            $stmt = $pdo->prepare("SELECT id FROM Projet WHERE client_id=:client_id ORDER BY id DESC LIMIT 1");
            $stmt->execute([':client_id'=> $data['client_id']]);
            $projet = $stmt->fetch();
         } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
        
         //Dans l'execute, vérifie si les variables existent. 
         try {
            $stmt = $pdo->prepare("INSERT INTO Budget (retraits_total, depots_total, date_fin, projet_id) VALUES (:retraits_total, :depots_total, :date_fin, :projet_id)");
            $stmt->execute([
                ':retraits_total' => isset($data['montantRetrait']) ? $data['montantRetrait'] : null,
                ':depots_total' => isset($data['montantDepot']) ? $data['montantDepot'] : null,
                ':date_fin' => isset($data['date_fin']) ? $data['date_fin'] : null,
                ':projet_id' => $projet["id"]
            ]);
            if (isset($data['montantRetrait']))
                depenseController::addDepense();
            if (isset($data['montantDepot']))
                revenuController::addRevenu();
            
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
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
}