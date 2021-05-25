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
    
    /**
     *  Saniterar user input och skickar till insertCustomer i models
     */
    private function createCustomer()
    {
        $name = $this->utils->sanitize($_POST['name']);
        $email = $this->utils->sanitize($_POST['email']);
        $password = $this->utils->sanitize($_POST['password']);
        $this->model->insertCustomer($name, $email, $password);
        $this->getFooter();
    }


    /**
     *  Kollar om det finns en aktiv session med inloggad användare 
     *  Tar emot POST request och skickar till funktionen loginUser
     */
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

    /**
     * Saniterar POST request
     * Loggar in admin eller customer beroende på userType input vi får från index route och skickar till motsvarande model
     */
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


    /**
     * Kollar om det finns en aktiv session med inloggad användare 
     * Renderear registration view
     * Kör createCustomer funktion om vi tar emot en POST
     */
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
            header("location: index.php?page=login");
        }
        $this->getFooter();
    }

    /**
     * Kör en session destroy på logout
     */
    public function logout()
    {
        session_destroy();
        header("location: index.php");
        exit();
    }


    /**
     * Hämtar view för header
     */
    private function getHeader($title)
    {
        $this->view->viewHeader($title);
    }


    /**
     * Hämtar view för footer
     */
    private function getFooter()
    {
        $this->view->viewFooter();
    }
}