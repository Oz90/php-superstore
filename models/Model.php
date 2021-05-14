<?php

class Model
{

    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function fetchAllProducts()
    {
        $products = $this->db->select("SELECT * FROM product");
        return $products;
    }

    public function fetchProductById($id)
    {
        $statement = "SELECT * FROM product WHERE id = :id";
        $params = array(":id" => $id);
        $product = $this->db->select($statement, $params);
        // print_r($product);
        return $product[0] ?? false;
    }

    public function fetchCustomerById($id)
    {

        $statement = "SELECT * FROM customers WHERE customer_id=:id";
        $parameters = array(':id' => $id);
        $customer = $this->db->select($statement, $parameters);
        return $customer[0] ?? false;
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



    public function insertOrder($customer_id, $order_id)
    {
        $customer = $this->fetchCustomerById($customer_id);
        if (!$customer) return false;

        $statement = "INSERT INTO order (customer_id, order_id)  
                      VALUES (:customer_id, :order_id)";
        $parameters = array(
            ':customer_id' => $customer_id,
            ':order_id' => $order_id
        );

        // Ordernummer
        $lastInsertId = $this->db->insert($statement, $parameters);

        return array('customer' => $customer, 'lastInsertId' => $lastInsertId);
    }

    public function updateProduct(
        $product_id,
        $product_name,
        $product_price,
        $product_description,
        $product_image,
        $product_category)
    {
        
        
        
        
        $product = $this->fetchProductById($product_id);
        if (!$product) return false;
        
        



        $statement = 
        "UPDATE product 

        SET (
            name = $product_name,
            price = $product_price,
            description = $product_description,
            image = $product_image,
            category = $product_category
        )
        WHERE (
            id = $product_id
        )
        ";
        
        // $parameters = array(
        //     ':product_id' => $product_id,
        //     ':product_name' => $product_name,
        //     ':product_price' => $product_price,
        //     ':product_description' => $product_description,
        //     ':product_image' => $product_image,
        //     ':product_category' => $product_category
        // );

        // Ordernummer
        
        $this->db->update($statement);
        
        // $lastInsertId = $this->db->update($statement, $parameters);
        //return array('customer' => $customer, 'lastInsertId' => $lastInsertId);
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
        // echo $password;
        // echo $dbPassword;

        if (!$password === $dbPassword) {
            $html = <<< HTML
            <div class="my-2 alert alert-danger">
                Wrong username or password!
            </div>
            HTML;

            echo $html;
            exit();
        }

        if (!isset($_SESSION))
            session_start();

        // Store data in session variables
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
                Email already taken!
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

        if (!isset($_SESSION))
            session_start();
        // Store data in session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $userId;
        $_SESSION["email"] = $email;

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
        // Ordernummer
        //        $lastInsertId = $this->db->insert($statement, $parameters);

        //   return array('customer' => $customer, 'lastInsertId' => $lastInsertId);
    }
}
