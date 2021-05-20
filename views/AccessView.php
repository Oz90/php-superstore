<?php

class AccessView
{
    private $utils;

    public function __construct($utils)
    {
        $this->utils = $utils;
    }

    public function viewHeader($title)
    {
        include_once("views/include/header.php");
    }

    public function viewFooter()
    {
        include_once("views/include/footer.php");
    }

    public function viewLoginPage()
    {
        $html = <<<HTML
            <div class="container registration-container">
                <div class="col-md-6 login-form-1 d-flex justify-content-center">
                    <form method="post">
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Your Email *" name="email" />
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Your Password *" name="password" />
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btnSubmit" value="Login" />
                        </div>
                    </form>
                </div>
            </div>

        HTML;

        echo $html;
    }

    public function viewRegistrationPage()
    {
        $html = <<<HTML
            <div class="container login-container">
                <div class="col-md-6 login-form-1 d-flex justify-content-center">
                    <form method="post" action="">
                        <div class="form-group">
                            <input type="name" class="form-control" placeholder="Your Name *" name="name" />
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Your Email *" name="email" />
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Your Password *" name="password" />
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btnSubmit" value="Register" />
                        </div>
                    </form>
                </div>
            </div>

        HTML;

        echo $html;
    }
}
