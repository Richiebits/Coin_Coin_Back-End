<?php

    class revenuController {
        public static function getRevenus($budgetId) {
            global $pdo;

            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=utf-8");

            try {
                $stmt = $pdo->prepare("SELECT * FROM Revenu WHERE budget_id=:budget_id");
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

            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=utf-8");
 
            $data = json_decode(file_get_contents('php://input'), true);
 
            //Dans l'execute, vérifie si les variables existent. 
            try {
                $stmt = $pdo->prepare("INSERT INTO Revenu (nom, montant, budget_id) VALUES (:nom, :montant, :budget_id)");
                $stmt->execute([
                    ':nom' => $data['nom'],
                    ':montant' => $data['montant'],
                    ':budget_id' => $data['budget_id']
                ]);
            } catch(PDOException $e) {
                http_response_code(500);
                echo json_encode(array("error"=> $e->getMessage()));
            }
        }
        public static function updateRevenu($id) {
            global $pdo;

            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=utf-8");

            $data = json_decode(file_get_contents('php://input'), true);
        
            try {
                $stmt = $pdo->prepare("UPDATE Revenu SET 
                    nom = :nom,
                    montant = :montant
                    WHERE id_revenu = :id_revenu"
                );
                $stmt->execute([
                    ':nom' => $data['nom'],
                    ':montant' => $data['montant'],
                    ':id_revenu' => $id
                ]);
            } catch(PDOException $e) {
                http_response_code(500);
                echo json_encode(array("error"=> $e->getMessage()));
            }
        }
    }
?>