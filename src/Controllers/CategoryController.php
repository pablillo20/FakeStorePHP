<?php

namespace Controllers;

use Lib\Pages;
use Exception;
use Models\Category;
use Services\CategoryService;

class CategoryController
{
    private Pages $pages;
    private CategoryService $CategoryService;

    public function __construct()
    {
        // Inicializa las páginas y el servicio de categorías
        $this->pages = new Pages();
        $this->CategoryService = new CategoryService();
    }

    public function createCategory()
    {
        // Verifica si el usuario ha iniciado sesión
        if (!isset($_SESSION['user'])) {
            $this->pages->render('Auth/loginForm');
        } else {
            // Verifica si la solicitud es POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Verifica si los datos están presentes
                if ($_POST['data']) {
                    $category = Category::fromArray($_POST['data']);
                    $category->sanitize();
                    // Valida los datos de la categoría
                    if ($category->validation()) {
                        try {
                            $this->CategoryService->registerCategory($category);
                            $this->pages->render('Category/registerCategory');
                        } catch (Exception $e) {
                            $_SESSION['register'] = 'Fail';
                            $_SESSION['errors'] = $e->getMessage();
                        }
                    } else {
                        $_SESSION['registerCategory'] = 'Fail';
                        $errores = Category::getErrores();
                        $this->pages->render('Category/registerCategory', ['errores' => $errores]);
                    }
                } else {
                    $_SESSION['registerCategory'] = 'Fail';
                }
            } else {
                $this->pages->render('Category/registerCategory');
            }
        }
    }
}