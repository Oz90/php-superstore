<?php
session_set_cookie_params(0);
session_start();

// Models
require_once("models/Database.php");
require_once("models/Model.php");
require_once("models/adminModel.php");
require_once("models/productModel.php");

// Views
require_once("views/View.php");
require_once("views/adminView.php");
require_once("views/productView.php");

// Controllers
require_once("controllers/Controller.php");
require_once("controllers/adminController.php");
require_once("controllers/productController.php");

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

//*Todo Skapat en local branch 
