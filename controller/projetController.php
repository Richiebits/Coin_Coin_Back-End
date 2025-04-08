<?php
//require_once __DIR__ . "budgetController.php";
class projetController {
    public static function getProjets($clientId) {
        //Permet d'avoir tous les projets d'un client
        global $pdo;

        // if(headers_sent($file, $line)){
        //     echo "Headers send in $file line $line";
        // }
    
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
            $stmt = $pdo->prepare("SELECT * FROM Projet WHERE client_id=:client_id");
            $stmt->execute([':client_id' => $clientId]);
            $projets = $stmt->fetchAll();
            echo json_encode($projets);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
    public static function getProjet($id) {
        //Permet d'avoir 1 projet d'un client
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
            $stmt = $pdo->prepare("SELECT * FROM Projet WHERE id=:id");
            $stmt->execute([':id' => $id]);
            $projet = $stmt->fetchAll();
            echo json_encode($projet);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
    public static function addProjet() {
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
            $stmt = $pdo->prepare("INSERT INTO Projet (nom, but_epargne, client_id) VALUES (:nom, :but_epargne, :client_id)");
            $stmt->execute([
                ':nom' => $data['nomProjet'],
                ':but_epargne' => $data['but_epargne'],
                ':client_id' => $userid
            ]);
            budgetController::addBudget();
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
    public static function updateProjet($id) {
        //Permet de mettre à jour un projet
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
            $stmt = $pdo->prepare("UPDATE Projet SET 
            nom = :nom, 
            but_epargne = :but_epargne
            WHERE id = :id");
            $stmt->execute([
                ':nom' => $data['nom'],
                ':but_epargne' => $data['but_epargne'],
                ':id' => $id
            ]);
            echo json_encode(['success' => true, 'message' => 'Projet modifié avec succès']);
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
    public static function deleteProjet($id, $clientId) {
        global $pdo;
    
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");
    
        try {
            $stmt = $pdo->prepare("SELECT id FROM Projet WHERE id = :id AND client_id = :client_id");
            $stmt->execute([':id' => $id, ':client_id' => $clientId]);
            $projet = $stmt->fetch();
    
            if (!$projet) {
                http_response_code(403);
                echo json_encode(["error" => "Projet non trouvé ou accès refusé"]);
                return;
            }
    
            $stmt = $pdo->prepare("DELETE FROM Projet WHERE id = :id");
            $stmt->execute([':id' => $id]);
    
            echo json_encode(['success' => true, 'message' => 'Projet supprimé avec succès']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }    
}

?>