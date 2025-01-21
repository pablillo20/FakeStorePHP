<?php

namespace Controllers;

use Lib\Pages;
use Exception;
use Services\ProductService;

class CartController {
    private Pages $pages;
    private ProductService $productService;

    public function __construct() {
        $this->pages = new Pages();
        $this->productService = new ProductService();
    }

    public function AddCart(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $productId = (int)$_POST['product_id'];

            $product = $this->productService->getProductById($productId);

            if($product){
                if(!isset($_SESSION['cart'])){
                    $_SESSION['cart'] = [];
                }
                
                if($product->getStock() > 0){
                    if(isset($_SESSION['cart'][$productId])){
                        if($_SESSION['cart'][$productId]['quantity'] < $product->getStock()){
                            $_SESSION['cart'][$productId]['quantity']++;
                            $_SESSION['message'] = "Producto añadido";
                        } else {
                            $_SESSION['message'] = "No se puede añadir más del stock disponible";
                        }
                    }else{
                        $_SESSION['cart'][$productId] = $product->toArray();
                        $_SESSION['cart'][$productId]['quantity'] = 1;
                        $_SESSION['message'] = "Producto añadido";
                    }
                } else {
                    $_SESSION['message'] = "Producto sin stock disponible";
                }
            }else{
                $_SESSION['message'] = "Producto no encontrado";
            }
        }
        $this->pages->render("Cart/showCart");
    }

    public function ShowCart(){
        if(!isset($_SESSION['user'])){
            $this->pages->render('Auth/loginForm');
        }else{
            $this->pages->render('Cart/showCart');
        }
    }

    public function updateCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)$_POST['product_id'];
            $action = $_POST['action'];
            $productStock = $this->productService->getProductById($productId);
            if (isset($_SESSION['cart'][$productId])) {
                if ($action === 'increase' && $_SESSION['cart'][$productId]['quantity'] < $productStock->getStock() ) {
                    $_SESSION['cart'][$productId]['quantity']++;
                } elseif ($action === 'decrease' && $_SESSION['cart'][$productId]['quantity'] > 1) {
                    $_SESSION['cart'][$productId]['quantity']--;
                } elseif ($action === 'decrease' && $_SESSION['cart'][$productId]['quantity'] == 1) {
                    unset($_SESSION['cart'][$productId]);
                }
            }
        }
        $this->pages->render('Cart/showCart');
    }
}