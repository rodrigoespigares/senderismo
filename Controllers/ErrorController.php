<?php

namespace Controllers;

use Lib\Pages;

/**
 * Clase para controlar errores
 */
class ErrorController
{
    // Crea un atributo de pages
    private static Pages $pages;

    /**
     * Constructor estático para inicializar la propiedad estática $pages
     */
    public static function initialize(): void
    {
        // Instancia la clase
        self::$pages = new Pages();
    }

    /**
     * Creando la función para provocar el error 404
     *
     * @return void
     */
    public static function show_err404(): void
    {
        // Comprueba que la propiedad esté inicializada antes de usarla
        if (!isset(self::$pages)) {
            // Inicia la clase
            self::initialize();
        }
        // Muestra la pagina con el error
        self::$pages->render("pages/error/404");
    }
}

// Inicializar la propiedad estática al cargar la clase
ErrorController::initialize();