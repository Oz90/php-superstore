<?php
session_set_cookie_params(0);
session_start();

require_once("models/Database.php");
require_once("models/Model.php");
require_once("views/View.php");
require_once("controllers/Controller.php");

//!: Skapa instans av databas
$database   = new Database("superstore", "root", "root");

//!: Skapa instans av model med nyskapade instansen av databasen
//!: Model Provides Data and associated Logic to the View
//!: I model har vi olika sätt att hämta data från databasen. Det är modellen för hur vi vill kunna interagera med databasen. Modellen används för att hantera data 
$model      = new Model($database);

//!: Skapa instans av View
//!: View Renders the model to the View 
$view       = new View();

//!: Skapa instans av Controller
//!: Controller interacts with Model And View
//!: Controllern hanterar alla GET requests. 
//!: Controllern Använder Model för att hämta data. 
//!: Controllern Använder View för att rendera data till browsern. 
$controller = new Controller($model, $view);

//! Run the main function in class Controller. 
$controller->main();


//*Todo Skapat en local branch 