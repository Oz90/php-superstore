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

    public function fetchAdminByEmail($email)
    {

        $statement = "SELECT * FROM admin WHERE email=:email";
        $parameters = array(':email' => $email);
        $admin = $this->db->select($statement, $parameters);
        return $admin[0] ?? false;
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

        // Store data in session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $adminId;
        $_SESSION["email"] = $email;
        $_SESSION["admin"] = true;

        header("location: ?page=admin");
    }
}
