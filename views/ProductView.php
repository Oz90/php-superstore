  
<?php

class ProductView
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

    public function viewAllProducts($products)
    {
        foreach ($products as $product) {
            $this->viewOneProduct($product);
        }
    }

    public function tableHeader()
    {
        $html = <<<HTML
                    <table class="table">
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                        </tr>
                    <tbody>
                HTML;

        echo $html;
    }

    public function tableFooter($sum)
    {
        echo "
        <tr>
            <td>Total Sum:</td>
            <td></td>
            <td>$ $sum </td>
            
        </tr>
        </tbody>
        </table>
        <form method='post'>
        <input type='submit' value='Order'>
        </form>
        ";
    }

    public function viewCartProduct($product, $quantity, $price)
    {
        $html = <<<HTML
                    <tr>
                        <td>$product[name]</td>
                        <td>$quantity</td>
                        <td>$ $price </td>
                    </tr>
        HTML;

        echo $html;
    }

    public function viewDetailPage($product)
    {
        $this->viewOneProduct($product);
    }
}
