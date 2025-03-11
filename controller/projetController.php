<?php

class projetController {
    public static function getProjets() {
        //Permet d'avoir tous les projets d'un client
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
    public static function getProjet($id) {
        //Permet d'avoir 1 projet d'un client
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