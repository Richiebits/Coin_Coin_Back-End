<?php

class projetController {
    public static function getProjets($email) {
        //Permet d'avoir tous les projets d'un client
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        try {
            $stmt = $pdo->prepare("SELECT * FROM Projet WHERE clientid=:clientid");
            $stmt->execute([':clientid' => $email]);
            $projets = $stmt->fetchAll();
            echo json_encode($projets);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
    public static function getProjet($id) {
        //Permet d'avoir tous les projets d'un client
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

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
        //DOIT S'ASSURER QUE LE CLIENTID EXISTE AVANT DE FAIRE LE FETCH
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $stmt = $pdo->prepare("INSERT INTO Projet (nom, but_epargne, Clientid) VALUES (:nom, :but_epargne, :Clientid)");
            $stmt->execute([
                ':nom' => $data['nom'],
                ':but_epargne' => $data['but_epargne'],
                ':Clientid' => $data['Clientid']
            ]);
            echo json_encode(['success' => true, 'message' => 'Projet créé avec succès']);
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
}

?>