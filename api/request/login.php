<?php
// HEADER SETTINGS
header("Access-Control-Allow-Origin: http://192.168.1.254:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/database.php";
include_once "../config/core.php";
include_once "../class/users.php";
require_once "../vendor/autoload.php";

use \Firebase\JWT\JWT;

// START SESSION AND CHECK IF JWT EXISTS IN THE SESSION
session_start();

if (!empty($_SESSION["jwt"])) exit($_SESSION["jwt"]);

// GET POST DATA FROM THE REQUEST
$inputJSON = file_get_contents("php://input");
$input = json_decode($inputJSON, TRUE);

// GET DATABASE CONNECTION AND RETURN ERRORS IF ANY
$database = new Database();
$db_connection = $database->getConnection();

if (is_integer($db_connection)) {
    http_response_code(500);
    exit();
}

if (is_object($db_connection)) {

    // GET USER CLASS
    $user = new Users($db_connection);

    // VALIDATE INPUTS AND RETURN ERRORS IF ANY
    $error_list = [];

    $password = $input["password"];
    $email = filter_var(strtolower($input["email"]), FILTER_SANITIZE_EMAIL);

    if (empty($password) || preg_match('/\s/', $password)) array_push($error_list, "invalid-password");
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) array_push($error_list, "invalid-email");
    if (!empty($error_list)) exit(json_encode($error_list));

    // CHECK IF THE USER EXISTS AND RETURN ERRORS IF ANY
    $check_user_exist = $user->checkUserExist(NULL, $email);

    if (is_integer($check_user_exist)) {
        http_response_code(500);
        exit();
    }

    if (empty($check_user_exist)) exit("not-existing-user");

    // LOGIN USER AND RETURN ERRORS IF ANY
    $login_user = $user->loginUser($email, $password);

    if (is_integer($login_user)) {
        http_response_code(500);
        exit();
    }

    if ($login_user === "wrong-password") exit($login_user);

    // GENERATE TOKEN AND RETURN THE DATA
    $token = array(
        "iat" => $token_issued,
        "exp" => $token_expiration,
        "data" => array(
            "id" => $login_user["id"],
            "username" => $login_user["username"],
            "email" => $login_user["email"],
            "created_at" => $login_user["created_at"]
        )
    );
    
    $jwt = JWT::encode($token, $privateKey, "RS256");

    // SAVE JWT IN A SESSION
    $_SESSION["jwt"] = $jwt;

    // $decoded = JWT::decode($jwt, $publicKey, array('RS256'));
    // $decoded_array = (array) $decoded;
}