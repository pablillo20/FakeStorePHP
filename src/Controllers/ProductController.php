<?php

namespace Controllers;

use Lib\Pages;
use Models\Product;
use Exception;
use Services\ProductService;
use Services\CategoryService;

class ProductController
{
    private Pages $pages;
    private ProductService $productService;
    private CategoryService $categoryService;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->productService = new ProductService();
        $this->categoryService = new CategoryService();
    }

    public function product()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['data']) {
                $product = Product::fromArray($_POST['data']);
                $product->sanitize();
                if ($product->validation()) {
                    try {
                        $categories = $this->categoryService->getAllCategories();

                        $this->productService->registerProduct($product);
                        $this->pages->render('Product/registerProduct', ['categories' => $categories]);
                    } catch (Exception $e) {
                        $_SESSION['register'] = 'Fail';
                        $_SESSION['errors'] = $e->getMessage();
                    }
                } else {
                    $categories = $this->categoryService->getAllCategories();
                    $_SESSION['registerProduct'] = 'Fail';
                    $errores = Product::getErrores();
                    $this->pages->render('Product/registerProduct', ['errores' => $errores, 'categories' => $categories]);
                }
            } else {
                $_SESSION['registerProduct'] = 'Fail'; // Si no hay datos
            }
        } else {
            $categories = $this->categoryService->getAllCategories();
            $this->pages->render('Product/registerProduct', ['categories' => $categories]);
        }
    }

    public function FilterProducts()
    {
        // Verificar si es una solicitud POST y si se proporciona un ID de categoría válido
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data']['categoria_id']) && $_POST['data']['categoria_id'] > 0) {
            $categoryId = $_POST['data']['categoria_id'];
            $products = $this->productService->getProductsByCategoryId($categoryId);
        } else {
            $products = $this->productService->getAllProducts();
        }

        // Obtener todas las categorías
        $categories = $this->categoryService->getAllCategories();

        // Renderizar la vista con categorías y productos
        $this->pages->render('Product/filterProducts', [
            'categories' => $categories,
            'products' => $products
        ]);
    }



    public function AllProducts()
    {
        if (!isset($_SESSION['user'])) {
            $this->pages->render('Auth/loginForm');
        } else {
            $products = $this->productService->getAllProducts();
            $this->pages->render('Product/allProduct', ['products' => $products]);
        }
    }

    public function editProducts($id)
    {
        if (!isset($_SESSION['user'])) {
            $this->pages->render('Auth/loginForm');
        } else {
            if (!isset($_SESSION['user'])) {
                $this->pages->render('Auth/loginForm');
            } else {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if ($_POST['data']) {
                        $product = Product::fromArray($_POST['data']);
                        $product->sanitize();
                        if ($product->validationEdit()) {
                            try {
                                $this->productService->updateProduct($product);
                                $products = $this->productService->getAllProducts();
                                $this->pages->render('Product/allProduct', ['products' => $products]);
                                $_SESSION['edit'] = 'Success';
                            } catch (Exception $e) {
                                $_SESSION['edit'] = 'Fail';
                                $_SESSION['errors'] = $e->getMessage();
                            }
                        } else {
                            $_SESSION['editProduct'] = 'Fail';
                            $errores = Product::getErrores();
                            $categories = $this->categoryService->getAllCategories();
                            $product = $this->productService->getProductById($id);
                            $this->pages->render('Product/editProduct', ['product' => $product, 'errores' => $errores, 'categories' => $categories, 'id' => $id]);
                        }
                    } else {
                        $_SESSION['editProduct'] = 'Fail'; // Si no hay datos
                    }
                } else {
                    if ($id) {
                        $product = $this->productService->getProductById($id);
                        if ($product) {
                            $categories = $this->categoryService->getAllCategories();
                            $this->pages->render('Product/editProduct', ['product' => $product, 'categories' => $categories]);
                        } else {
                            $_SESSION['editProduct'] = 'Fail'; // Si no se encuentra el producto
                        }
                    } else {
                        $_SESSION['editProduct'] = 'Fail'; // Si no hay ID de producto
                    }
                }
            }
        }
    }

    public function DeleteProduct($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            try {
                $this->productService->DeleteProduct($id);
                $products = $this->productService->getAllProducts();
                $this->pages->render('Product/allProduct', ['products' => $products]);
                $_SESSION['delete'] = 'Success';
            } catch (Exception $e) {
                $_SESSION['delete'] = 'Fail';
                $_SESSION['errors'] = $e->getMessage();
            }
        } else {
            $_SESSION['editProduct'] = 'Fail';
        }
    }
}