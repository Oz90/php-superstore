<?php

class AdminView
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

    public function viewAdminPage()
    {
        $html = <<<HTML
            </div>
                <hr>
                <p class="text-center">
                    <a href="?page=admin&view=create">Create Product</a>
                </p>
                <hr>
                <p class="text-center">
                    <a href="?page=admin&view=products">View Products</a>
                </p>
                <hr>
                <p class="text-center">
                    <a href="?page=admin&view=orders">View Orders</a>
                </p>
        HTML;

        echo $html;
    }

    public function viewAdminOrders($order)
    {
        //echo $is_shipped;

        $html = <<<HTML

            <div class="col-md-6">
                    <div class="card m-1">
                        <div class="card-body">
                            <div class="card-title text-center">
                                <h4>Order id: $order[order_id]</h4>
                                <h4>Is shipped: $order[is_shipped]</h4>
                                <form method="post">
                                    <select name="order_shipped">
                                    <option value="1">Shipped</option>
                                    <option value="0">Not shipped</option>
                                    </select>
                                    <br><br>
                                    <input type="submit" value="Update">
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

    public function viewOrderStatus($order_id, $shipping_message)
    {

        $this->utils->confirmShippingMessage($order_id, $shipping_message);
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
            </div>
        HTML;

        echo $html;
    }

    public function viewAllProducts($products)
    {
        foreach ($products as $product) {
            if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
                $this->viewAdminProduct($product);
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
        HTML;

        echo $html;
    }
}
