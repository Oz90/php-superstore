<?php
class ProductController
{

    private $model;
    private $view;
    private $utils;

    public function __construct($model, $view, $utils)
    {
        $this->model = $model;
        $this->view = $view;
        $this->utils = $utils;
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
            if (isset($_SESSION['loggedin'])) {
                $id = $this->utils->sanitize($_POST['product_id']);
                $this->model->addToCart($id);
            } else {
                header('location: index.php?page=login');
            }
        }
        $this->getFooter();
    }

    public function productPage()
    {
        $this->getHeader("Beställning");

        $id = $this->utils->sanitize($_GET['id']);
        $product = $this->model->fetchProductById($id);

        if ($product)
            $this->view->viewDetailPage($product);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['loggedin'])) {
                $id = $this->utils->sanitize($_POST['product_id']);
                $this->model->addToCart($id);
            } else {
                header('location: index.php?page=login');
            }
        }
        $this->getFooter();
    }

    public function shoppingCart()
    {
        $this->getHeader('Shoppingcart');
        $productsArray = array();
        $totalPrice = 0;
        // print_r ($_SESSION['shoppingcart']);
        if (isset($_SESSION['shoppingcart'])) {
            $shoppingCartItems = array_count_values($_SESSION['shoppingcart']);
            $shoppingCartQuantities = array_values($shoppingCartItems);

            foreach (array_keys($shoppingCartItems) as $item) {
                $product = $this->model->fetchProductById($item);
                array_push($productsArray, $product);
            }

            $this->view->tableHeader();

            foreach ($productsArray as $index => $product) {
                $quantity = $shoppingCartQuantities[$index];
                $price = $quantity * $product['price'];
                $totalPrice += $price;
                $this->view->viewCartProduct($product, $quantity, $price);
            }

            $this->view->tableFooter($totalPrice);
            $this->getFooter();

            if (($_SERVER['REQUEST_METHOD']) === 'POST') {

                $customer_id = intval($_SESSION['id']);
                $order_id = $this->model->insertOrder($customer_id, $totalPrice);

                foreach ($productsArray as $index => $product) {
                    $quantity = $shoppingCartQuantities[$index];
                    $product_id = $product['id'];
                    $this->model->insertOrderItem($order_id, $product_id, $quantity);
                }
                $_SESSION['shoppingcart'] = array();

                header('location: index.php');
            }
        }
    }
}
