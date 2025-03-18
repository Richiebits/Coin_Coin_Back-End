<?php

class clientController {

    public static function getClient($id) {
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");
        
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

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        $data = json_decode(file_get_contents('php://input'), true);
        try {
            $stmt = $pdo->prepare("SELECT id FROM Client WHERE email=:email AND mot_de_passe=PASSWORD(:mot_de_passe)");
            $stmt->execute([
                ':email' => $data['email'],
                ':mot_de_passe' => $data['mot_de_passe']
            ]);
            $client = $stmt->fetch();
            echo json_encode($client);
        } catch(PDOException $e) {
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
}
?>