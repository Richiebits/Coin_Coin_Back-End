<?php

require_once(__DIR__."/router.php");

require "config.php";
require "tokenFunction.php";
require "controller/clientController.php";
require "controller/projetController.php";
require_once "controller/budgetController.php";
require "controller/depenseController.php";
require "controller/revenuController.php";
require "controller/historiqueController.php";

//Routes pour client
get('/api/client/$id', function($id) {
    clientController::getClient($id);
});
post('/api/client/connexion', function() {
    clientController::connecterClient();
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
delete('/api/projet/delete/$projetId/$clientId', function($projetId, $clientId) {
    projetController::deleteProjet($projetId, $clientId);
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

//Routes pour historique
get('api/historique/$projetId', function($projetId) {
    historiqueController::getHistorique($projetId);
});
?>