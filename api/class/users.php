<?php
class Users {
    
    // CONNECTION
    private $db_connection;

    // TABLES
    private $db_users_table = "users";

    // DB CONNECTION
    public function __construct($db_connection) {
        $this->db_connection = $db_connection;
    }

    // CHECK IF USER EXIST 
    public function checkUserExist($username, $email) {
        try {

            $error_list = [];

            if (!empty($username)) {

                $query_check_username = $this->db_connection->prepare("SELECT COUNT(1) FROM $this->db_users_table WHERE username = :username");
                $query_check_username->bindParam(":username", $username, PDO::PARAM_STR);
                $query_check_username->execute();

                if ($query_check_username->fetchColumn()) array_push($error_list, "existing-username");
            }

            if (!empty($email)) {

                $query_check_email = $this->db_connection->prepare("SELECT COUNT(1) FROM $this->db_users_table WHERE email = :email");
                $query_check_email->bindParam(":email", $email, PDO::PARAM_STR);
                $query_check_email->execute();
                
                if ($query_check_email->fetchColumn()) array_push($error_list, "existing-email");
            }

            return $error_list;
        } catch (PDOException $e) {

            return (integer) $e->getCode();
        }
    }

    // CREATE NEW USER
    public function createNewUser($username, $password, $email) {
        try {

            $query = $this->db_connection->prepare("INSERT INTO $this->db_users_table (username, password, email) VALUES (:username, :password, :email)");
            
            $query->bindParam(":username", $username, PDO::PARAM_STR);
            $query->bindParam(":password", $password, PDO::PARAM_STR);
            $query->bindParam(":email", $email, PDO::PARAM_STR);

            $query->execute();
        } catch (PDOException $e) {

            return (integer) $e->getCode();
        } 
    }

    // LOGIN USER
    public function loginUser($email, $password) {
        try {

            $query = $this->db_connection->prepare("SELECT * FROM $this->db_users_table WHERE email = :email");
            $query->bindParam(":email", $email, PDO::PARAM_STR);
            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password ,$result["password"])) {

                unset($result["password"]);
                return $result;
            };

            return "wrong-password";
        } catch (PDOException $e) {

            return (integer) $e->getCode();
        } 
    }
}