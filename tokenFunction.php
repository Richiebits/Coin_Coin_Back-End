<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function verifyToken()
{
    global $API_SECRET;
    //On récupère toutes les entêtes de la requête
    $headers = getallheaders();
    //On s'intéresse spécifiquement à l'entête Authorization
    //Cette dernière comporte le mot clé Bearer suivi du Token.
    //On enlève le mode "Bearer " pour ne conserver que la chaine de caractères du Token
    $jwt = str_replace('Bearer ', '', $headers['Authorization'] ?? '');
    //On décode le Token
    try {
        $decoded = JWT::decode($jwt, new Key($API_SECRET, 'HS256'));
        // Si le token est valide, on retourne l'id de l'usager qui a été stocké dans le Token
        return $decoded->user_id;
    } catch (\Firebase\JWT\ExpiredException $e) {
        // Gérer l'expiration du token
        throw new Exception('Token expiré!');
    } catch (\Exception $e) {
        // Gérer les autres erreurs
        throw new Exception('Erreur de token: ' . $e->getMessage());
    }
}
?>