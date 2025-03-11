<?php

require_once(__DIR__."/router.php");

require "config.php";
require "controller/clientController.php";

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
// //---------------------------------------------------------------------------
// get('/api/activities/filter', function() {
//     activityController::getFilteredActivities();
// });
// //Une activité selon le id
// get('/api/activities/$id', function($id) {
//     activityController::getActivityId($id);
// });
// //Création d'une activité
// post('/api/activities', function() {
//     activityController::addActivity();
// });
// //modifier une activité
// put('/api/activities/$id', function($id) {
//     activityController::updateActivity($id);
// })
?>