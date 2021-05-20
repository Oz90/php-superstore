<?php

class AdminView
{


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
        include_once("views/include/login.php");
    }


    public function viewAdminPage()
    {
        include_once("views/include/admin.php");
    }


    public function adminViewProduct()
    {
        echo "Viewing product page";
    }

    public function viewAdminOrders($order)
    {
  

    //echo $is_shipped;
    $update = ($order['is_shipped'] == 0) ? "Mark as shipped" : "Mark as not shipped";

    $html = <<<HTML

    <div class="col-md-6">
            <div class="card m-1">
                <div class="card-body">
                    <div class="card-title text-center">
                        <h4>Order id: $order[order_id]</h4>
                        <h4>Is shipped: $order[is_shipped]</h4>
                        <form method="post">
                            <select name="order_shipped">
                            <option value="1">shipped</option>
                            <option value="0">awaiting</option>
                            </select>
                            <br><br>
                            <input type="submit" value="$update">
                            <input type="hidden" name="order_id" value="$order[order_id]">
                        </form>
                    </div>
                </div>
            </div>
        </a>
    </div>  <!-- col -->
HTML;

echo $html;



    }

    // Bra att läsa om PHP Templating och HEREDOC syntax!
    // https://css-tricks.com/php-templating-in-just-php/
    public function viewAllOrders($orders)
    {

        foreach ($orders as $order) {
            if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
                $this->viewAdminOrders($order);
            }
        }
    }


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



    public function viewCreatePage()
    {
        $this->viewCreateForm();
    }
    public function viewEditPage($product)
    {
        // $this->viewOneProduct($product);
        $this->viewEditForm($product);
    }

    public function viewCreateForm()
    {
        $html = <<<HTML
            <div class="col-md-6">
                <form action="#" method="post">
                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" required 
                            class="form-control form-control-lg my-2">

                    <label for="product_price">Product Price</label>
                    <input type="number" name="product_price" required 
                            class="form-control form-control-lg my-2" 
                            >
                    
                    <label for="product_description">Product Description</label>
                    <input type="text" name="product_description" required 
                            class="form-control form-control-lg my-2" 
                            >

                    <label for="product_image">Product Image URL</label>
                    <input type="text" name="product_image" required 
                            class="form-control form-control-lg my-2" 
                            >

                    <label for="product_category">Product Category</label>
                    <select name="product_category" class="form-control form-control-lg my-2" required>
                        <option value="mens clothing">Mens Clothing</option>
                        <option value="womens clothing">Womens Clothing</option>
                        <option value="electronics">Electronics</option>
                        <option value="jewelery">Jewelery</option>
                    </select>
                    <input type="submit" name="create" class="form-control my-2 btn btn-lg btn-outline-success" 
                            value="Create Product">
                </form>
                
            <!-- col avslutas efter ett meddelande från viewConfirmMessage eller viewErrorMessage -->
        HTML;

        echo $html;
    }
    public function viewEditForm($product)
    {

        $html = <<<HTML
            <div class="col-md-6">
            
                <form action="#" method="post">
                    <input type="hidden" name="product_id" 
                            value="$product[id]">

                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" required 
                            class="form-control form-control-lg my-2" 
                            value="$product[name]">

                    <label for="product_price">Product Price</label>
                    <input type="number" name="product_price" required 
                            class="form-control form-control-lg my-2" 
                            value="$product[price]">
                    
                    <label for="product_description">Product Description</label>
                    <input type="text" name="product_description" required 
                            class="form-control form-control-lg my-2" 
                            value="$product[description]">

                    <label for="product_image">Product Image URL</label>
                    <input type="text" name="product_image" required 
                            class="form-control form-control-lg my-2" 
                            value="$product[image]">

                    <label for="product_category">Product Category</label>
                    <select name="product_category" class="form-control form-control-lg my-2" value="$product[category]" required>
                        <option value="mens clothing">Mens Clothing</option>
                        <option value="womens clothing">Womens Clothing</option>
                        <option value="electronics">Electronics</option>
                        <option value="jewelery">Jewelery</option>
                    </select>
                    <input type="submit" name="update" class="form-control my-2 btn btn-lg btn-outline-success" 
                            value="Update Product">
                    <input type="submit" name="delete" class="form-control my-2 btn btn-lg btn-outline-danger" 
                            value="Delete Product">
                </form>
                
            <!-- col avslutas efter ett meddelande från viewConfirmMessage eller viewErrorMessage -->
        HTML;

        echo $html;
    }


    public function viewConfirmMessage($customer, $lastInsertId)
    {
        $this->printMessage(
            "<h4>Tack $customer[name]</h4>
            <p>Vi kommer att skicka filmen till följande e-post:</p>
            <p>$customer[email]</p>
            <p>Ditt ordernummer är $lastInsertId </p>
            </div> <!-- col  avslutar Beställningsformulär -->
            ",
            "success"
        );
    }

    public function viewErrorMessage($customer_id)
    {
        $this->printMessage(
            "<h4>Kundnummer $customer_id finns ej i vårt kundregister!</h4>
            <h5>Kontakta kundtjänst</h5>
            </div> <!-- col  avslutar Beställningsformulär -->
            ",
            "warning"
        );
    }

    /**
     * En funktion som skriver ut ett felmeddelande
     * $messageType enligt Bootstrap Alerts
     * https://getbootstrap.com/docs/5.0/components/alerts/
     */
    public function printMessage($message, $messageType = "danger")
    {
        $html = <<< HTML
            <div class="my-2 alert alert-$messageType">
                $message
            </div>
        HTML;

        echo $html;
    }
}
