<?php
require_once(__DIR__ . '/../config.php');
use Firebase\JWT\JWT;

class clientController {

    public static function getClient($id) {
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
            $stmt = $pdo->prepare("SELECT * FROM Client WHERE id=:id");
            $stmt->execute([':id' => $id]);
            $client = $stmt->fetch();
            echo json_encode($client);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
    public static function connecterClient() {
        global $pdo;
        global $API_SECRET;
        
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        $data = json_decode(file_get_contents('php://input'), true);
        try {
            $stmt = $pdo->prepare("SELECT id FROM Client WHERE email=:email AND mot_de_passe=PASSWORD(:mot_de_passe)");
            $stmt->execute([
                ':email' => $data['email'],
                ':mot_de_passe' => $data['mot_de_passe']
            ]);
            $response = $stmt->fetch();
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }

        //Création et envoie du token
        if($response){
            $payload = [
                //Info à mettre dans le token
                "iss" => "http://localhost:8000", // Émetteur du token
                "aud" => "http://localhost:8000", // Audience du token
                "iat" => time(), // Temps où le JWT a été émis
                "exp" => time() + 3600, // Expiration du token (1 heure plus tard)
                "user_id" => $response['id']
            ];
            $jwt = JWT::encode($payload, $API_SECRET, 'HS256'); // Génère le token
            $response['message'] = "Authentification réussie";
            $response['token'] = $jwt;
            http_response_code(200);
            echo json_encode($response);
        } else {
            http_response_code(401);
            $response['error'] = "Non autorisé";
            echo json_encode($response);
        }
    }
    public static function getClients() {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");
        
        try {
            $stmt = $pdo->prepare("SELECT * FROM Client");
            $stmt->execute();
            $clients = $stmt->fetchAll();
            echo json_encode($clients);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
    public static function addClient() {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        print_r(file_get_contents('php://input'));

        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $stmt = $pdo->prepare("INSERT INTO Client (email, nom, prenom, tel, mot_de_passe) VALUES (:email, :nom, :prenom, :tel, PASSWORD(:mot_de_passe))");
            $stmt->execute([
                ':email' => $data['email'],
                ':nom' => $data['nom'],
                ':prenom' => $data['prenom'],
                ':tel' => $data['tel'],
                ':mot_de_passe' =>  $data['mot_de_passe']
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
    public static function updateClient($id) {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $stmt = $pdo->prepare("UPDATE Client SET 
                nom = :nom, 
                prenom = :prenom, 
                email = :email,
                tel = :tel, 
                mot_de_passe = PASSWORD(:mot_de_passe)
                WHERE id = :id");

            $stmt->execute([
                ':nom' => $data['nom'],
                ':prenom' => $data['prenom'],
                ':email' => $data['email'],
                ':tel' => $data['tel'],
                ':mot_de_passe' => $data['mot_de_passe'],
                'id' => $id
            ]);
            echo json_encode(['success' => true, 'message' => 'Client modifié avec succès']);

        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
    public static function deleteClient($id) {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        try{
            $userid = verifyToken();
            $stmt = $pdo->prepare("SELECT is_admin FROM Client WHERE id=:id");
            $stmt->execute([':id' => $userid]);
            $client = $stmt->fetch();
            if (!$client || $client["is_admin"] != 1)
                throw new Exception("Utilisateur n'a pas les permis d'administrateur");
        } catch(Exception $e){
            $response = [];
            http_response_code(401);
            $response['error'] = "Non autorisé : " . $e;
            echo json_encode($response);
            return;
        }


        try {
            $stmt = $pdo->prepare("DELETE FROM Client WHERE id=:id");

            $stmt->execute(['id' => $id]);
            echo json_encode(['success' => true, 'message' => 'Client supprimé avec succès']);

        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
}
?>