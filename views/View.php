<?php

class View
{

    public function viewHeader($title)
    {
        include_once("views/include/header.php");
    }

    public function viewFooter()
    {
        include_once("views/include/footer.php");
    }

    public function viewAboutPage()
    {
        include_once("views/include/about.php");
    }

    public function viewLoginPage()
    {
        include_once("views/include/login.php");
    }

    public function viewRegistrationPage()
    {
        include_once("views/include/registration.php");
    }
}
