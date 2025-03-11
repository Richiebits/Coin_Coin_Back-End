<?php

require_once(__DIR__."/router.php");

require "config.php";
require "controller/clientController.php";
require "controller/projetController.php";

//Pour client
get('/api/client/$email', function($email) {
    clientController::getClient($email);
});
get('/api/client', function() {
    clientController::getClients();
});
post('/api/client', function() {
    clientController::addClient();
});
put('/api/client/$email', function($email) {
    clientController::updateClient($email);
});

//Pour projet
get('/api/projet/$id', function($id) {
    projetController::getProjet($id);
});
get('/api/projet', function() {
    projetController::getProjets();
});
post('/api/projet', function() {
    projetController::addProjet();
});
put('/api/projet/$id', function($id) {
    projetController::updateProjet($id);
});
?>