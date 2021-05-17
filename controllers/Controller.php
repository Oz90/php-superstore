<?php
class Controller
{

    private $model;
    private $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    public function main()
    {
        $this->router();
    }

    private function router()
    {
        $page = $_GET['page'] ?? "";

        switch ($page) {
            case "about":
                $this->about();
                break;
            case "order":
                $this->order();
                break;
            case "login":
                $this->login("Customer");
                break;
            case "login-admin":
                $this->login("Admin");
                break;
            case "admin":
                $this->admin();
                break;
            case "logout":
                $this->logout();
                break;
            case "registration":
                $this->registration();
                break;
            default:
                $this->getAllProducts();
        }
    }

    private function login($userType)
    {
        // Check if the user is already logged in, if yes then redirect him to welcome page
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            header("location: index.php");
            exit;
        }


        $this->getHeader("Login " . $userType);
        $this->view->viewLoginPage();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->loginUser($userType);
        }
        $this->getFooter();
    }

    private function registration()
    {
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            header("location: index.php");
            exit;
        }

        $this->getHeader("registration");
        $this->view->viewRegistrationPage();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->createCustomer();
        }
        $this->getFooter();
    }

    private function logout()
    {
        // Destroy the session.
        session_destroy();

        // Redirect to login page
        header("location: index.php");
        exit;
    }

    private function loginUser($userType)
    {

        $email = $this->sanitize($_POST['email']);
        $password = $this->sanitize($_POST['password']);
        // print_r($name);

        if ($userType === "Admin") {
            $this->model->loginAdmin($email, $password);
        } elseif ($userType === "Customer") {
            $this->model->loginCustomer($email, $password);
        }

        $this->getFooter();
    }

    private function getHeader($title)
    {
        $this->view->viewHeader($title);
    }

    private function getFooter()
    {
        $this->view->viewFooter();
    }

    private function about()
    {
        $this->getHeader("Om Oss");
        $this->view->viewAboutPage();
        $this->getFooter();
    }

    private function admin()
    {

        // Check if the user is already logged in, if yes then redirect him to welcome page
        if (!isset($_SESSION["admin"]) && !$_SESSION["admin"] === true) {
            header("location: index.php");
            exit;
        }

        $this->getHeader("Admin");
        $this->view->viewAdminPage();

        if (isset($_GET['view'])) {
            $view = $this->sanitize($_GET['view']);

            if ($view === "products") {
                $this->getAdminProducts();
            }
            if ($view === "edit") {
                $this->editProduct();
            }
            if ($view === "orders") {
                $this->view->adminViewOrders();
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

    private function getAllProducts()
    {
        $this->getHeader("Välkommen");
        $products = $this->model->fetchAllProducts();
        $this->view->viewAllProducts($products);
        $this->getFooter();
    }

    private function getAdminProducts()
    {
        $products = $this->model->fetchAllProducts();
        $this->view->viewAllProducts($products);
    }

    private function deleteProduct()
    {
        $id = $this->sanitize($_GET['id']);
        $this->model->deleteProductById($id);
        header("location: ?page=admin&view=products");
    }

    private function editProduct()
    {
        $this->getHeader("Edit Product");

        $id = $this->sanitize($_GET['id']);
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

    private function order()
    {
        $this->getHeader("Beställning");

        $id = $this->sanitize($_GET['id']);
        $product = $this->model->fetchProductById($id);

        if ($product)
            $this->view->viewOrderPage($product);

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $this->processOrderForm();

        $this->getFooter();
    }

    private function createCustomer()
    {
        $name = $this->sanitize($_POST['name']);
        $email = $this->sanitize($_POST['email']);
        $password = $this->sanitize($_POST['password']);
        // print_r($name);

        $new_user = $this->model->insertCustomer($name, $email, $password);

        // $this->view->viewOrderPage($product);

        /*   if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $this->processOrderForm();*/

        $this->getFooter();
    }


    private function processEditForm()
    {
        $product_id             = $this->sanitize($_POST['product_id']);
        $product_name           = $this->sanitize($_POST['product_name']);
        $product_price          = $this->sanitize($_POST['product_price']);
        $product_description    = $this->sanitize($_POST['product_description']);
        $product_image          = $this->sanitize($_POST['product_image']);
        $product_category       = $this->sanitize($_POST['product_category']);

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
        $product_name           = $this->sanitize($_POST['product_name']);
        $product_price          = $this->sanitize($_POST['product_price']);
        $product_description    = $this->sanitize($_POST['product_description']);
        $product_image          = $this->sanitize($_POST['product_image']);
        $product_category       = $this->sanitize($_POST['product_category']);

        $this->model->createProduct(
            $product_name,
            $product_price,
            $product_description,
            $product_image,
            $product_category
        );


        header("location: ?page=admin&view=products");
    }

    private function processOrderForm()
    {
        $product_id    = $this->sanitize($_POST['product_id']);
        $customer_id = $this->sanitize($_POST['customer_id']);
        $confirm = $this->model->insertOrder($customer_id, $product_id);

        if ($confirm) {
            $customer = $confirm['customer'];
            $lastInsertId = $confirm['lastInsertId'];
            $this->view->viewConfirmMessage($customer, $lastInsertId);
        } else {
            $this->view->viewErrorMessage($customer_id);
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
