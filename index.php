<?php
session_set_cookie_params(0);
session_start();

// Models
require_once("models/Database.php");
require_once("models/Model.php");
require_once("models/AdminModel.php");
require_once("models/ProductModel.php");

// Views
require_once("views/View.php");
require_once("views/AdminView.php");
require_once("views/ProductView.php");

// Controllers
require_once("controllers/Controller.php");
require_once("controllers/AdminController.php");
require_once("controllers/ProductController.php");

//!: Skapa instans av databas
$database   = new Database("superstore", "root", "root");

//!: Skapa instans av model med nyskapade instansen av databasen
//!: Model Provides Data and associated Logic to the View
//!: I model har vi olika sätt att hämta data från databasen. Det är modellen för hur vi vill kunna interagera med databasen. Modellen används för att hantera data 
$model      = new Model($database);
$adminModel      = new AdminModel($database);
$productModel      = new ProductModel($database);

//!: Skapa instans av View
//!: View Renders the model to the View 
$view       = new View();
$productView       = new ProductView();
$adminView       = new AdminView();

//!: Skapa instans av Controller
//!: Controller interacts with Model And View
//!: Controllern hanterar alla GET requests. 
//!: Controllern Använder Model för att hämta data. 
//!: Controllern Använder View för att rendera data till browsern. 
$controller = new Controller($model, $view);
$adminController = new AdminController($adminModel, $adminView);
$productController = new ProductController($productModel, $productView);

//! Run the main function in class Controller. 

$page = $_GET['page'] ?? "";

switch ($page) {
    case "admin":
        $adminController->admin();
        break;
    case "login-admin":
        $adminController->login("Admin");
        break;
    case "logout":
        $controller->logout();
        break;
    case "registration":
        $controller->registration();
        break;
    case "login":
        $controller->login("Customer");
        break;
    case "product-page":
        $productController->productPage();
        break;
    case "shoppingcart":
        $productController->shoppingCart();
        break;
    case "about":
        $controller->about();
        break;
    default:
        $productController->getAllProducts();
}

