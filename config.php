<?php
require_once __DIR__."/vendor/php-jwt/JWTExceptionWithPayloadInterface.php";
require_once __DIR__."/vendor/php-jwt/BeforeValidException.php";
require_once __DIR__."/vendor/php-jwt/CachedKeySet.php";
require_once __DIR__."/vendor/php-jwt/ExpiredException.php";
require_once __DIR__."/vendor/php-jwt/JWK.php";
require_once __DIR__."/vendor/php-jwt/JWT.php";
require_once __DIR__."/vendor/php-jwt/Key.php";
require_once __DIR__."/vendor/php-jwt/SignatureInvalidException.php";

//Clé secrète pour token
global $API_SECRET;
$API_SECRET = "Y!z8q^5Xe0gMW*PLp&nd2m@3KxVfTR#";

//Configuration et connexion à la base de données 
$host = 'db';
$db = 'mydatabase';
$user = 'user';
$pass = 'password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

?>
