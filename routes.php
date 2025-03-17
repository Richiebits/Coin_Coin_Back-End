<?php

require_once(__DIR__."/router.php");

require "config.php";
require "controller/clientController.php";
require "controller/projetController.php";
require "controller/budgetController.php";
require "controller/depenseController.php";
require "controller/revenuController.php";

//Routes pour client
get('/api/client/$id', function($id) {
    clientController::getClient($id);
});
get('/api/client/email/$email', function($email) {
    clientController::getClientAvecEmail($email);
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

//Routes pour depense
get('/api/depense/budget/$budgetId', function($budgetId) {
    depenseController::getDepenses($budgetId);
});
post('/api/depense', function() {
    depenseController::addDepense();
});
put('/api/depense/$id', function($id) {
    depenseController::updateDepense($id);
});

//Routes pour revenu
get('/api/revenu/budget/$budgetId', function($budgetId) {
    revenuController::getRevenus($budgetId);
});
post('/api/revenu', function() {
    revenuController::addRevenu();
});
put('/api/revenu/$id', function($id) {
    revenuController::updateRevenu($id);
});
?>