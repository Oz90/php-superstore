<?php
class AdminController
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

    public function admin()
    {
        if (!isset($_SESSION["admin"]) && !$_SESSION["admin"] === true) {
            header("location: index.php");
            exit();
        }

        $this->getHeader("Admin");
        $this->view->viewAdminPage();

        if (isset($_GET['view'])) {
            $view = $this->utils->sanitize($_GET['view']);

            if ($view === "products") {
                $this->getAdminProducts();
            }
            if ($view === "edit") {
                $this->editProduct();
            }
            if ($view === "orders") {
                $this->updateOrders();
            }
            if ($view === "delete") {
                $this->deleteProduct();
            }
            if ($view === "create") {
                $this->createProduct();
            }
        }
        $this->getFooter();
    }

    private function updateOrders()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order_id = $this->utils->sanitize($_POST['order_id']);
            $is_shipped = $this->utils->sanitize($_POST['order_shipped']);
            $this->model->updateOrders($order_id, $is_shipped);
            $shipping_message = $is_shipped == 0 ? "waiting to be shipped" : "shipped";
            $this->view->viewOrderStatus($order_id, $shipping_message);
            $orders = $this->model->fetchAllOrders();
            $this->view->viewAllOrders($orders);
        } else {
            $orders = $this->model->fetchAllOrders();
            $this->view->viewAllOrders($orders);
        }
    }

    private function getAdminProducts()
    {
        $products = $this->model->fetchAllProducts();
        $this->view->viewAllProducts($products);
    }

    private function deleteProduct()
    {
        $id = $this->utils->sanitize($_GET['id']);
        $this->model->deleteProductById($id);
        header("location: ?page=admin&view=products");
    }



    private function editProduct()
    {
        $this->getHeader("Edit Product");

        $id = $this->utils->sanitize($_GET['id']);
        $product = $this->model->fetchProductById($id);

        if ($product)
            $this->view->viewEditPage($product);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['update'])) {
                $this->processEditForm();
            } elseif (isset($_POST['delete'])) {
                $this->deleteProduct();
            }
        }

        $this->getFooter();
    }

    private function createProduct()
    {
        $this->getHeader("Create Product");
        $this->view->viewCreatePage();
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $this->processCreateForm();
    }



    private function processEditForm()
    {
        $product_id             = $this->utils->sanitize($_POST['product_id']);
        $product_name           = $this->utils->sanitize($_POST['product_name']);
        $product_price          = $this->utils->sanitize($_POST['product_price']);
        $product_description    = $this->utils->sanitize($_POST['product_description']);
        $product_image          = $this->utils->sanitize($_POST['product_image']);
        $product_category       = $this->utils->sanitize($_POST['product_category']);

        $this->model->updateProduct(
            $product_id,
            $product_name,
            $product_price,
            $product_description,
            $product_image,
            $product_category
        );


        header("location: ?page=admin&view=products");
    }

    private function processCreateForm()
    {
        $product_name           = $this->utils->sanitize($_POST['product_name']);
        $product_price          = $this->utils->sanitize($_POST['product_price']);
        $product_description    = $this->utils->sanitize($_POST['product_description']);
        $product_image          = $this->utils->sanitize($_POST['product_image']);
        $product_category       = $this->utils->sanitize($_POST['product_category']);

        $this->model->createProduct(
            $product_name,
            $product_price,
            $product_description,
            $product_image,
            $product_category
        );
        header("location: ?page=admin&view=products");
    }
}
