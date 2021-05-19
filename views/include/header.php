<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Videobutiken</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body class="container">
    <?php

    $cart_amount = count($_SESSION['shoppingcart']) > 0 ? count($_SESSION['shoppingcart']) : "";

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        echo "<a class='btn btn-primary' href='?page=logout'>logout</a>";
        echo "<a class='btn btn-primary' href='?page=shoppingcart'> 🛒 $cart_amount</a>";
    } else {
        echo "<a class='btn btn-primary' href='?page=login'>login</a>";
        echo " <a class='btn btn-primary' href='?page=registration'>registration</a>";
    }

    $headerUrl = (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) ? '?page=admin' : 'index.php';
    ?>

    <h1 class="text-center">
        <a href="<?= $headerUrl ?>">
            Klädbutiken
        </a>
    </h1>

    <h2 class="text-center"><?php echo $title; ?></h2>
    <div class="row">