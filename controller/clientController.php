<?php

class clientController {

    public static function getClient($email) {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");
        
        try {
            $stmt = $pdo->prepare("SELECT * FROM Client WHERE email=:email");
            $stmt->execute([':email' => $email]);
            $client = $stmt->fetchAll();
            echo json_encode($client);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
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

        $password = password_hash($data['mot_de_passe']);

        try {
            $stmt = $pdo->prepare("INSERT INTO Client (email, nom, prenom, tel, mot_de_passe) VALUES (:email, :nom, :prenom, :tel, :mot_de_passe)");
            $stmt->execute([
                ':email' => $data['email'],
                ':nom' => $data['nom'],
                ':prenom' => $data['prenom'],
                ':tel' => $data['tel'],
                ':mot_de_passe' => $password
            ]);
            echo json_encode(['success' => true, 'message' => 'Client créé avec succès']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
    public static function updateClient($email) {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        $data = json_decode(file_get_contents('php://input'), true);

        $password = password_hash($data['mot_de_passe']);

        try {
            $stmt = $pdo->prepare("UPDATE Client SET 
                nom = :nom, 
                prenom = :prenom, 
                tel = :tel, 
                mot_de_passe = :mot_de_passe
                WHERE email = :email");

            $stmt->execute([
                ':nom' => $data['nom'],
                ':prenom' => $data['prenom'],
                ':tel' => $data['tel'],
                ':mot_de_passe' => $password,
                ':email' => $email
            ]);
            echo json_encode(['success' => true, 'message' => 'Client modifié avec succès']);

        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
}
?>