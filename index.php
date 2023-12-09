<?php
    session_start();
    // Cargo todas las clases
    require_once("vendor/autoload.php");
    // Carga del archivo de configuracion
    require_once("config/config.php");
    $dotenv =Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
    // Carga del header para la vista
    // Uso el FrontController para mostrar el controlador por defecto configurado en el archivo config
    use Controllers\FrontController;
    // Carga de la función main del controlado.
    FrontController::main();
    // Carga del footer para la vista
?>
