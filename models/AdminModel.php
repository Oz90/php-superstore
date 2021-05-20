<?php

class AdminModel
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

    public function fetchAllOrders()
    {
        $orders = $this->db->select("SELECT * FROM `order`");
        return $orders;
    }


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
        //   return array('order' => $order_id);
    }

    // public function fetchOrderById($order_id)
    // {
    //     $statement = "SELECT * FROM `order` WHERE order_id=:order_id";
    //     $parameters = array(':order_id' => $order_id);
    //     $order = $this->db->select($statement, $parameters);
    //     return $order;
    // }

    public function fetchProductById($id)
    {
        $statement = "SELECT * FROM product WHERE id = :id";
        $params = array(":id" => $id);
        $product = $this->db->select($statement, $params);
        return $product[0] ?? false;
    }

    public function deleteProductById($id)
    {
        $statement = "DELETE FROM product WHERE id = :id";
        $params = array(":id" => $id);
        $product = $this->db->delete($statement, $params);
        // return $product[0] ?? false;
    }

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
