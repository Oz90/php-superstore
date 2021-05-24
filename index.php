<?php
session_set_cookie_params(0);
session_start();

// Models
require_once("models/Database.php");
require_once("models/AccessModel.php");
require_once("models/AdminModel.php");
require_once("models/ProductModel.php");

// Views
require_once("views/AccessView.php");
require_once("views/AdminView.php");
require_once("views/ProductView.php");

// Controllers
require_once("controllers/AccessController.php");
require_once("controllers/AdminController.php");
require_once("controllers/ProductController.php");

//Utils
require_once("utils/ControllerUtils.php");
require_once("utils/ViewUtils.php");

//!: Skapa instans av databas
$database   = new Database("superstore", "root", "root");

//!: Skapa instans av model med nyskapade instansen av databasen
//!: Model Provides Data and associated Logic to the View
//!: I model har vi olika sätt att hämta data från databasen. Det är modellen för hur vi vill kunna interagera med databasen. Modellen används för att hantera data 
$accessModel      = new AccessModel($database);
$adminModel      = new AdminModel($database);
$productModel      = new ProductModel($database);

$viewUtils = new ViewUtils();

//!: Skapa instans av View
//!: View Renders the model to the View 
$accessView       = new AccessView($viewUtils);
$productView       = new ProductView($viewUtils);
$adminView       = new AdminView($viewUtils);

//Instansiera utils
$controllerUtils = new ControllerUtils();

//!: Skapa instans av Controller
//!: Controller interacts with Model And View
//!: Controllern hanterar alla GET requests. 
//!: Controllern Använder Model för att hämta data. 
//!: Controllern Använder View för att rendera data till browsern. 
$accessController = new AccessController($accessModel, $accessView, $controllerUtils);
$adminController = new AdminController($adminModel, $adminView, $controllerUtils);
$productController = new ProductController($productModel, $productView, $controllerUtils);

//! Run the main function in class Controller. 

$page = $_GET['page'] ?? "";

switch ($page) {
    case "admin":
        $adminController->admin();
        break;
    case "login":
        $accessController->login("Customer");
        break;
    case "login-admin":
        $accessController->login("Admin");
        break;
    case "logout":
        $accessController->logout();
        break;
    case "registration":
        $accessController->registration();
        break;
    case "product-page":
        $productController->productPage();
        break;
    case "shoppingcart":
        $productController->shoppingCart();
        break;
    default:
        $productController->getAllProducts();
}
