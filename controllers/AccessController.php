<?php
class AccessController
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
    public function login($userType)
    {
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            header("location: index.php");
            exit();
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
            exit();
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
        session_destroy();
        header("location: index.php");
        exit();
    }

    private function loginUser($userType)
    {
        $email = $this->utils->sanitize($_POST['email']);
        $password = $this->utils->sanitize($_POST['password']);

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

    private function createCustomer()
    {
        $name = $this->utils->sanitize($_POST['name']);
        $email = $this->utils->sanitize($_POST['email']);
        $password = $this->utils->sanitize($_POST['password']);
        $this->model->insertCustomer($name, $email, $password);
        $this->getFooter();
    }
}
