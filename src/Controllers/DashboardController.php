<?php 
namespace Controllers;

use Lib\Pages;

class DashboardController {
    private Pages $pages;

    public function __construct() {
        // Inicializa las páginas
        $this->pages = new Pages();
    }
    
    public function index() {
        // Renderiza la página principal del dashboard
        $this->pages->render('Layout/principal');
    }
}
?>