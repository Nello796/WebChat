<?php
// HEADER SETTINGS
header("Access-Control-Allow-Origin: http://192.168.1.254:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../config/database.php";
include "../class/users.php";

// GET POST DATA FROM THE REQUEST
$inputJSON = file_get_contents("php://input");
$input = json_decode($inputJSON, TRUE);

// GET DATABASE CONNECTION
$database = new Database();
$db_connection = $database->getConnection();

if (is_integer($db_connection)) {
    http_response_code(500);
    exit();
}

// PREPARE INPUTS 
if (is_object($db_connection)) {

    // GET AND VALIDATE INPUTS
    $error_list = [];

    $username = str_replace(" ", "", $input["username"]);
    $password = $input["password"];
    $email = filter_var(strtolower($input["email"]), FILTER_SANITIZE_EMAIL);

    if (empty($username)) array_push($error_list, "invalid-username");
    if (empty($password) || preg_match('/\s/', $password)) array_push($error_list, "invalid-password");
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) array_push($error_list, "invalid-email");

    // RETURN ERRORS IF ANY AND STOP THE EXECUTION OF THE SCRIPT
    if (!empty($error_list)) exit(json_encode($error_list));

    // CHECK IF THE USER EXISTS AND RETURN ERRORS IF ANY
    $user = new Users($db_connection);
    $check_user_exist = $user->checkUserExist($username, $email);

    if (is_integer($check_user_exist)) {
        http_response_code(500);
        exit();
    }

    if (!empty($check_user_exist)) exit(json_encode($check_user_exist));

    // HASH PASSWORD
    $password_encrypted = password_hash($password, PASSWORD_DEFAULT);

    // CREATE USER
    $user = new Users($db_connection);
    $new_user = $user->createNewUser($username, $password_encrypted, $email);

    exit(true);
}