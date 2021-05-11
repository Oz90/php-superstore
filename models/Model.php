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
        $statement = "SELECT * FROM films WHERE film_id = :id";
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



    public function saveOrder($customer_id, $order_id)
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

    public function createCustomer($name, $email, $password)
    {
        $customer = $this->fetchCustomerByEmail($email);
            if ($customer){
                echo "user already exists";
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