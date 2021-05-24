<?php

class AdminModel
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    /**
     * Fetcha alla produkter från databasen
     */
    public function fetchAllProducts()
    {
        $products = $this->db->select("SELECT * FROM product");
        return $products;
    }
 /**
     * Fetcha alla ordrar från databasen
     */
    public function fetchAllOrders()
    {
        $orders = $this->db->select("SELECT * FROM `order`");
        return $orders;
    }

    /**
     * Uppdatera ordrar i databasen
     * Sätter is_shipped och not shipped på valt order_id
     */
    public function updateOrders($order_id, $is_shipped)
    {
        $statement =
            "UPDATE `order` SET 
            is_shipped = :is_shipped
        WHERE 
            order_id = :order_id";

        $parameters = array(
            ':is_shipped' => $is_shipped,
            ':order_id' => $order_id
        );
        $this->db->update($statement, $parameters);
    }

/**
 * Hämtar och returnerar produkt med hjälp av id 
*/
    public function fetchProductById($id)
    {
        $statement = "SELECT * FROM product WHERE id = :id";
        $params = array(":id" => $id);
        $product = $this->db->select($statement, $params);
        return $product[0] ?? false;
    }

    /**
 * Raderar produkt med hjälp av id 
*/
    public function deleteProductById($id)
    {
        $statement = "DELETE FROM product WHERE id = :id";
        $params = array(":id" => $id);
        $product = $this->db->delete($statement, $params);
    }

    /**
 * Tar emot formdata
 * Validerar att produkten finns
 * Uppdaterar produkten i databasen med hjälp av nytt formdata
*/
    public function updateProduct(
        $product_id,
        $product_name,
        $product_price,
        $product_description,
        $product_image,
        $product_category
    ) {
        $product = $this->fetchProductById($product_id);
        if (!$product) return false;

        $statement =
            "UPDATE product SET 
            name = :product_name,
            price = :product_price,
            description = :product_description,
            image = :product_image,
            category = :product_category
        WHERE 
            id = :product_id";

        $parameters = array(
            ':product_id' => $product_id,
            ':product_name' => $product_name,
            ':product_price' => $product_price,
            ':product_description' => $product_description,
            ':product_image' => $product_image,
            ':product_category' => $product_category
        );

        $this->db->update($statement, $parameters);
        return array('product' => $product);
    }

    
    /**
     * Tar emot formdata
 * Skapar  produkt i databasen med hjälp av formdata
*/
    public function createProduct(
        $product_name,
        $product_price,
        $product_description,
        $product_image,
        $product_category
    ) {
        $statement =
            "INSERT INTO product (
                name, 
                price, 
                description,
                image,
                category
            ) VALUES (
                :product_name,
                :product_price,
                :product_description,
                :product_image,
                :product_category
            )";

        $parameters = array(
            ':product_name' => $product_name,
            ':product_price' => $product_price,
            ':product_description' => $product_description,
            ':product_image' => $product_image,
            ':product_category' => $product_category
        );

        $this->db->insert($statement, $parameters);
    }
}