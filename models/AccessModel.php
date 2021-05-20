<?php

class AccessModel
{

    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function fetchCustomerByEmail($email)
    {
        $statement = "SELECT * FROM customer WHERE email=:email";
        $parameters = array(':email' => $email);
        $customer = $this->db->select($statement, $parameters);
        return $customer[0] ?? false;
    }

    public function fetchAdminByEmail($email)
    {
        $statement = "SELECT * FROM admin WHERE email=:email";
        $parameters = array(':email' => $email);
        $admin = $this->db->select($statement, $parameters);
        return $admin[0] ?? false;
    }

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
            session_set_cookie_params(0);
            session_start();
        }

        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $adminId;
        $_SESSION["email"] = $email;
        $_SESSION["admin"] = true;

        header("location: ?page=admin");
    }

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
            session_set_cookie_params(0);
            session_start();
        }
        // Store data in session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $userId;
        $_SESSION["email"] = $email;
        $_SESSION['shoppingcart'] = array();

        header("location: index.php");
    }

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
