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
        $this->pages = new Pages();
        $this->CategoryService = new CategoryService();
    }

    public function createCategory()
    {
        if (!isset($_SESSION['user'])) {
            $this->pages->render('Auth/loginForm');
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($_POST['data']) {
                    $category = Category::fromArray($_POST['data']);
                    $category->sanitize();
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