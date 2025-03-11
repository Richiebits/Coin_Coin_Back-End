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
        //Permet d'ajouter un projet
        global $pdo;

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=utf-8");

        try {
            //à compléter
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

        try {
            //à compléter
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error"=> $e->getMessage()));
        }
    }
}

?>