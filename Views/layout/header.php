<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Senderismo</title>
        

        <link rel="stylesheet" href="<?=BASE_URL?>src/css/normalize.css">
        <link rel="stylesheet" href="<?=BASE_URL?>src/css/header.css">
        <link rel="stylesheet" href="<?=BASE_URL?>src/css/base.css">        
        <link rel="stylesheet" href="<?=BASE_URL?>vendor/stefangabos/zebra_pagination/public/css/zebra_pagination.css">
        <link rel="stylesheet" href="<?=BASE_URL?>src/css/login.css">
        <link rel="stylesheet" href="<?=BASE_URL?>src/css/commit.css">
        <link rel="stylesheet" href="<?=BASE_URL?>src/css/edit.css">
        <link rel="stylesheet" href="<?=BASE_URL?>src/css/footer.css">
        <link rel="stylesheet" href="<?=BASE_URL?>src/css/error.css">
        <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>
    </head>
    <body>
         
    <header>
        <a href="<?=BASE_URL?>"><h1>Senderismo</h1></a>
        <?php
            // Comprueba si existe la sesion
            if(!isset($_SESSION['identity'])):?>
                <form action="<?= BASE_URL?>Login/login" method="post" class="container">
                    <button type="submit" name="login" class="log">Log in</button>
                    <button type="submit" name="register" class="reg">Sign up</button>
                </form>
        <?php 
            // En caso de no existir
            elseif(isset($_SESSION['identity'])):?>
            <form action="<?= BASE_URL?>Login/logout" method="post" class="container">
                <button type="submit" name="login" class="log">Log out</button>
            </form>
        <?php endif;?>
    </header>
    <main>