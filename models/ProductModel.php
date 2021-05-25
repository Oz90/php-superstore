<?php

class ProductModel
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }
/**
 * Fetcha alla produkter från databasen
 * Returnera produkterna
 */
    public function fetchAllProducts()
    {
        $products = $this->db->select("SELECT * FROM product");
        return $products;
    }

   /**
    * Fetcha en produkt 
    * Skicka med statement och params som består av produktens id
    * Skapa en array $product och Gör en select med hjälp av params och statement
    * returnera det första objektet i $product 
     */ 
    public function fetchProductById($id)
    {
        $statement = "SELECT * FROM product WHERE id = :id";
        $params = array(":id" => $id);
        $product = $this->db->select($statement, $params);
        return $product[0] ?? false;
    }

    /**
     * Lägg till en produkt i varukorgen
     * Pusha in produktens id i shoppingcart array. 
     */
    public function addToCart($id)
    {
        if (isset($id)) {
            array_push($_SESSION['shoppingcart'], $id);
        }
    }

    /**
     * Insert en order i datbasen
     * Ta emot customer id och totalpris
     * Insert $order_id som tar emot $statement och $parameters
     * Vi skapar först en order som vi vill fylla med item senare (=>insertOrderItem) med hjälp av returnerat $order_id. 
     */
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

    /** 
     * Ta emot $order_id $product_id och $quantity
     * order_item är en tabell som vi tillskriver med $order_id, $product_id och $quantity
     * Gör en insert i databasen med $statement och $parameters
     * 
    */

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