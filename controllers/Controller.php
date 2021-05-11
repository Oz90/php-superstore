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
                $this->login();
                break;
            case "registration":
                $this->registration();
                break;
            default:
                $this->getAllProducts();
        }
        
    }

    private function login(){
          // Check if the user is already logged in, if yes then redirect him to welcome page
          if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            header("location: index.php");
            exit;
        }
    
        $this->getHeader("login");
        $this->view->viewLoginPage();

          

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->loginUser();
        }
        $this->getFooter();
    }

    private function registration(){
        $this->getHeader("registration");
        $this->view->viewRegistrationPage();
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->createUser();
        }
        $this->getFooter();
    }


    private function loginUser(){

        $email = $this->sanitize($_POST['email']);
        $password = $this->sanitize($_POST['password']);
       // print_r($name);

        $new_user = $this->model->loginCustomer($email, $password);

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

    private function getAllProducts()
    {
        $this->getHeader("Välkommen");
        $products = $this->model->fetchAllProducts();
        $this->view->viewAllProducts($products);
        $this->getFooter();
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