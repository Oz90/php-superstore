<?php
class ProductController
{

    private $model;
    private $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    private function getHeader($title)
    {
        $this->view->viewHeader($title);
    }

    private function getFooter()
    {
        $this->view->viewFooter();
    }


    public function getAllProducts()
    {
        $this->getHeader("Välkommen");
        $products = $this->model->fetchAllProducts();
        $this->view->viewAllProducts($products);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $this->sanitize($_POST['product_id']);
            $this->model->addToCart($id);
        }

        $this->getFooter();
    }


    public function productPage()
    {
        $this->getHeader("Beställning");

        $id = $this->sanitize($_GET['id']);
        $product = $this->model->fetchProductById($id);

        if ($product)
            $this->view->viewDetailPage($product);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $this->sanitize($_POST['product_id']);
            $this->model->addToCart($id);
        }

        $this->getFooter();
    }


    public function shoppingCart()
    {
        $this->getHeader('Shoppingcart');
        $productsArray = array();
        $totalPrice = 0;
        if (isset($_SESSION['shoppingcart'])) {
            $shoppingCartItems = array_count_values($_SESSION['shoppingcart']);
            // $shoppingCartCount = array_count_values($_SESSION['shoppingcart']);
            $shoppingCartQuantities = array_values($shoppingCartItems);


            // print_r($shoppingCartItems);
            // echo "<br>";
            // print_r($shoppingCartQuantities);
            foreach (array_keys($shoppingCartItems) as $item) {
                $product = $this->model->fetchProductById($item);
                $totalPrice += $product['price'];
                array_push($productsArray, $product);
            }

            print_r($shoppingCartQuantities);
            echo "<br>";
            print_r($productsArray);
            $this->view->tableHeader();
            foreach ($productsArray as $product) {
                $this->view->viewCartProduct($product);
            }
            $this->view->tableFooter($totalPrice);
            $this->getFooter();
        }
    }

    /**
     * Sanitize Inputs
     * https://www.w3schools.com/php/php_form_validation.asp
     */
    public function sanitize($text)
    {
        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);
        return $text;
    }
}
