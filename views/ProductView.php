<?php

class ProductView
{

    public function viewHeader($title)
    {
        include_once("views/include/header.php");
    }

    public function viewFooter()
    {
        include_once("views/include/footer.php");
    }

    public function viewCartPage()
    {
        include_once("views/include/cart.php");
    }


    // Bra att läsa om PHP Templating och HEREDOC syntax!
    // https://css-tricks.com/php-templating-in-just-php/

    public function viewOneProduct($product)
    {
        $html = <<<HTML
        
            <div class="col-md-6">
                <a class="text-decoration-none" href="?page=product-page&id=$product[id]">
                    <div class="card m-1">
                        <img class="card-img-top" src="$product[image]" 
                             alt="$product[name]">
                        <div class="card-body">
                            <div class="card-title text-center">
                                <h4>$product[name]</h4>
                                <h5>Pris: $product[price] kr</h5>
                                <form method="post">
                                    <input type="hidden" name="product_id" value="$product[id]">
                                    <input type="submit" value="Lägg till produkt">
                                </form>
                            </div>
                        </div>
                    </div>
                </a>
            </div>  <!-- col -->
        HTML;

        echo $html;
    }

    public function viewAdminProduct($product)
    {
        $html = <<<HTML
        
            <div class="col-md-6">
                    <div class="card m-1">
                        <div class="card-body">
                            <div class="card-title text-center">
                                <h4>$product[name]</h4>
                                <h5>Pris: $product[price] kr</h5>
                                <a href="?page=admin&view=edit&id=$product[id]">
                                    <button>Edit</button>
                                </a>                                    
                            </div>
                        </div>
                    </div>
            </div>  <!-- col -->
        HTML;

        echo $html;
    }

    public function viewAllProducts($products)
    {
        foreach ($products as $product) {
            if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
                $this->viewAdminProduct($product);
            } else {
                $this->viewOneProduct($product);
            }
        }
    }

    public function viewDetailPage($product)
    {
        $this->viewOneProduct($product);
        //$this->viewOrderForm($product);
    }
}
