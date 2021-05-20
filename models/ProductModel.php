<?php

class ProductModel
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
        return $product[0] ?? false;
    }

    public function addToCart($id)
    {

        if (isset($id)) {
            array_push($_SESSION['shoppingcart'], $id);
        }


    }


    public function insertOrder($customer_id, $totalPrice)
    {
      
        $statement = "INSERT INTO `order` (customer_id, total_price)  
                      VALUES (:customer_id, :total_price)";
        
        $parameters = array(
            ':customer_id' => $customer_id,
            ':total_price' => $totalPrice
        );

        // Ordernummer
        $order_id = $this->db->insert($statement, $parameters);
 
        return $order_id;
    }

    public function insertOrderItem($order_id, $product_id, $quantity)
    {
        
        $statement = "INSERT INTO order_item (order_id, product_id, quantity)  
                      VALUES (:order_id, :product_id, :quantity)";
        $parameters = array(
            ':order_id' => $order_id,
            ':product_id' => $product_id,
            ':quantity' => $quantity
        );

        $this->db->insert($statement, $parameters);          
    }
}