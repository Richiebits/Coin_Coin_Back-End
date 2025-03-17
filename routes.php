<?php

require_once(__DIR__."/router.php");

require "config.php";
require "controller/clientController.php";
require "controller/projetController.php";
require "controller/budgetController.php";

//Routes pour client
get('/api/client/$id', function($id) {
    clientController::getClient($id);
});
get('/api/client', function() {
    clientController::getClients();
});
post('/api/client', function() {
    clientController::addClient();
});
put('/api/client/$id', function($id) {
    clientController::updateClient($id);
});

//Routes pour projet
get('/api/projet/$id', function($id) {
    projetController::getProjet($id);
});
get('/api/projet/client/$clientId', function($clientId) {
    projetController::getProjets($clientId);
});
post('/api/projet', function() {
    projetController::addProjet();
});
put('/api/projet/$id', function($id) {
    projetController::updateProjet($id);
});

//Routes pour budget
get('/api/budget/projet/$projetId', function($projetId) {
    budgetController::getbudget($projetId);
});
post('/api/budget', function() {
    budgetController::addBudget();
});
put('/api/budget/projet/$projetId', function($projetId) {
    budgetController::updateBudget($projetId);
});
?>