<?php 
namespace Controllers;

use Lib\Pages;

class ErrorController {
    public static function error404() {
        // Renderiza la página de error 404
        $pages = new Pages();
        $pages->render('Error/error404', ['titulo' => 'Página no encontrada']);
    }
}
?>