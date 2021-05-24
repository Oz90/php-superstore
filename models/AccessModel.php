<?php

class AccessModel
{

    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }
/**
 * Fetcha customer från databasen med hjälp av email
 */
    public function fetchCustomerByEmail($email)
    {
        $statement = "SELECT * FROM customer WHERE email=:email";
        $parameters = array(':email' => $email);
        $customer = $this->db->select($statement, $parameters);
        return $customer[0] ?? false;
    }


/**
 * Fetcha adminanvändare med hjälp av email
 */
    public function fetchAdminByEmail($email)
    {
        $statement = "SELECT * FROM admin WHERE email=:email";
        $parameters = array(':email' => $email);
        $admin = $this->db->select($statement, $parameters);
        return $admin[0] ?? false;
    }

    /**
 * Fetcha adminanvändare med hjälp av email
 * errorhantering för om email adressen inte finns i databasen 
 * errorhantering för om man skriver fel lösenord
 * annars skapas en session och användaren skickas till admin page  
 */
    public function loginAdmin($email, $password)
    {
        $admin = $this->fetchAdminByEmail($email);
        if (!$admin) {
            $html = <<< HTML
            <div class="my-2 alert alert-danger">
                You don't have have access to this page. 
            </div>
            HTML;

            echo $html;
            exit();
        }

        $adminId = $admin['id'];
        $email = $admin['email'];
        $dbPassword = $admin['password'];

        if (!$password === $dbPassword) {
            $html = <<< HTML
            <div class="my-2 alert alert-danger">
                Wrong username or password!
            </div>
            HTML;

            echo $html;
            exit();
        }

        if (!isset($_SESSION)) {
            session_start();
        }

        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $adminId;
        $_SESSION["email"] = $email;
        $_SESSION["admin"] = true;

        header("location: ?page=admin");
    }

/**
 * Fetcha customer med hjälp av email
 * errorhantering för om email adressen inte finns i databasen 
 * errorhantering för om man skriver fel lösenord
 * annars skapas en session och användaren skickas till index  
 */
    public function loginCustomer($email, $password)
    {
        $customer = $this->fetchCustomerByEmail($email);
        if (!$customer) {
            $html = <<< HTML
            <div class="my-2 alert alert-danger">
                Email not registered!
            </div>
            HTML;

            echo $html;
            exit();
        }

        $userId = $customer['id'];
        $email = $customer['email'];
        $dbPassword = $customer['password'];

        if (!password_verify($password, $dbPassword)) {
            $html = <<< HTML
            <div class="my-2 alert alert-danger">
                Wrong username or password!
            </div>
            HTML;

            echo $html;
            exit();
        }

        if (!isset($_SESSION)) {
            session_start();
        }
        // Store data in session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $userId;
        $_SESSION["email"] = $email;
        $_SESSION['shoppingcart'] = array();

        header("location: index.php");
    }
/**
 * Lägger till customer i databasen
 * Errorhantering om customer finns
 * Annars gör vi en insert till databasen
 */
    public function insertCustomer($name, $email, $password)
    {
        $customer = $this->fetchCustomerByEmail($email);
        if ($customer) {
            $html = <<< HTML
            <div class="my-2 alert alert-danger">
                User already exist!
            </div>
            HTML;

            echo $html;
            exit();
        }

        $statement = "INSERT INTO customer (name, email, password)  
                      VALUES (:name, :email, :password)";
        $parameters = array(
            ':name' => $name,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT)
        );
        $this->db->insert($statement, $parameters);
    }
}