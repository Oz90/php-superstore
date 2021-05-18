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

    public function login($userType)
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

    public function registration()
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

    public function logout()
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

    public function about()
    {
        $this->getHeader("Om Oss");
        $this->view->viewAboutPage();
        $this->getFooter();
    }

    private function createCustomer()
    {
        $name = $this->sanitize($_POST['name']);
        $email = $this->sanitize($_POST['email']);
        $password = $this->sanitize($_POST['password']);
        // print_r($name);

        $new_user = $this->model->insertCustomer($name, $email, $password);

        // $this->view->viewDetailPage($product);

        /*   if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $this->processOrderForm();*/

        $this->getFooter();
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
