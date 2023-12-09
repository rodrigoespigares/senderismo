<?php
// Uso la clase monedero llamandola con su espacion de nombres
namespace Controllers;

class FrontController
{
    /**
     * Función que gestiona el main accediendo al 
     * resto de controladores y sus métodos, llamados acciones o en este caso "action"
     *
     * @return void
     */
    public static function main()
    {
        /**
         * Se comprueba si se pasa un controlador mediante $_GET, es decir por la URL
         * en caso de que no lo haga se ejecutará el controlador por defecto.
         */
        if (isset($_GET['controller'])) {
            $nombre_controlador = "\\Controllers\\" . $_GET['controller'] . "Controller";
        } else {
            $nombre_controlador = "\\Controllers\\" . CON_DEFAULT;
        }
        /**
         * Se comprueba si el controlador es una clase y en caso contrario se mostrará 
         * el error 404 de la clase ErrorController.
         */
        if (class_exists($nombre_controlador)) {
            // Se crea una variable de la clase
            $controlador = new $nombre_controlador();
            /**
             * Se comprueba que el metodo recibido existe, en caso contraio se ejecutará 
             * el por defecto
             */
            if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
                $action = $_GET['action'];
                // Se ejecuta el método del controlador
                $controlador->$action();
            } else if (!isset($_GET["controller"]) && !isset($_GET["action"])) {
                $action_default = ACT_DEFAULT;
                // Se ejecuta el controlador por defecto
                
                $controlador->$action_default();
            } else {
                echo ErrorController::show_err404();
            }
        } else {
            echo ErrorController::show_err404();
        }
    }
}
