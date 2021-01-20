<?php
include "../config/database.php";
include "../class/users.php";

// GET POST DATA FROM THE REQUEST
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

// GET DATABASE CONNECTION
$database = new Database();
$db_connection = $database->getConnection();

if (is_integer($db_connection)) exit("Something went wrong, please try again.");

// PREPARE INPUTS 
if (is_object($db_connection)) {

    // GET AND VALIDATE INPUTS
    $error_list = [];

    $username = str_replace(" ", "", $input["username"]);
    $password = $input["password"];
    $email = filter_var(strtolower($input["email"]), FILTER_SANITIZE_EMAIL);

    if (empty($username)) array_push($error_list, "username");
    if (empty($password) || preg_match('/\s/', $password)) array_push($error_list, "password");
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) array_push($error_list, "email");

    // RETURN ERRORS IF ANY AND STOP THE EXECUTION OF THE SCRIPT
    if (!empty($error_list)) exit(json_encode($error_list));

    // CHECK IF THE USER IS ALREADY REGISTERED
    $user = new Users($db_connection);
    $check_user_exist = $user->checkUserExist($username, $email);

    // RETURN ERRORS IF ANY AND STOP THE EXECUTION OF THE SCRIPT
    if (is_integer($check_user_exist)) exit("Something went wrong, please try again.");
    if (!empty($check_user_exist)) exit(json_encode($check_user_exist));

    // HASH PASSWORD
    $password_encrypted = password_hash($password, PASSWORD_DEFAULT);

    // CREATE USER
    $user = new Users($db_connection);
    $new_user = $user->createNewUser($username, $password_encrypted, $email);

    exit(true);
}