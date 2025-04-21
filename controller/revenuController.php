<?php

    class revenuController {
        public static function getRevenus($budgetId) {
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
                $stmt = $pdo->prepare("SELECT * FROM Depot WHERE budget_id=:budget_id");
                $stmt->execute([':budget_id' => $budgetId]);
                $revenus = $stmt->fetchAll();
                echo json_encode($revenus);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(array("error"=> $e->getMessage()));
            }
        }
        public static function addRevenu() {
            global $pdo;

            //Vérification du token et obtention de l'id de l'utilisateur
            try{
                $userid = verifyToken();
            }   catch(Exception $e){
                $response = [];
                http_response_code(401);
                $response['error'] = "Non autorisé : " . $e;
                echo json_encode($response);
                return;
            }
 
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
                $stmt = $pdo->prepare("INSERT INTO Depot (nom, montant, depot_recurrence, budget_id) VALUES (:nom, :montant, :depot_recurrence, :budget_id)");
                $stmt->execute([
                    ':nom' => $data['nomDepot'],
                    ':montant' => $data['montantDepot'],
                    ':depot_recurrence' => $data['depot_recurrence'],
                    ':budget_id' => $budget['id']
                ]);

                echo json_encode(["success" => true]);

            } catch(PDOException $e) {
                http_response_code(500);
                echo json_encode(array("error"=> $e->getMessage()));
            }
        }
        public static function updateRevenu($id) {
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
                $stmt = $pdo->prepare("UPDATE Depot SET 
                    nom = :nom,
                    montant = :montant
                    WHERE id_depot = :id_depot"
                );
                $stmt->execute([
                    ':nom' => $data['nom'],
                    ':montant' => $data['montant'],
                    ':id_depot' => $id
                ]);
            } catch(PDOException $e) {
                http_response_code(500);
                echo json_encode(array("error"=> $e->getMessage()));
            }
        }
    }
?>