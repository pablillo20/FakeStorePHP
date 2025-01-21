<?php

namespace Controllers;

use Lib\Pages;
use Models\OrderLine;
use Services\OrderLineService; 
use Services\ProductService; // Importar ProductService
use Exception;


class OrderLineController
{
    private Pages $pages;
    private OrderLineService $orderLineService;
    private ProductService $productService; // Inicializar ProductService

    public function __construct()
    {
        $this->pages = new Pages();
        $this->orderLineService = new OrderLineService();
        $this->productService = new ProductService(); // Inicializar ProductService
    }

    public function createOrderLine()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['cart']) && isset($_SESSION['user']['id'])) {
                foreach ($_SESSION['cart'] as $product) {
                    $orderLine = new OrderLine(
                        null,
                        $_SESSION['order_id'],
                        $product['id'], 
                        $product['quantity']
                    );
                    $orderLine->sanitize();
                    if ($orderLine->validation()) {
                        try {
                            $this->orderLineService->createOrderLine($orderLine);
                            // Restar el stock del producto
                            $this->productService->decreaseStock($product['id'], $product['quantity']);
                            $_SESSION['cart'] = [];

                        } catch (Exception $e) {
                            $_SESSION['create'] = 'Fail';
                            $_SESSION['errors'] = $e->getMessage();
                        }
                    } else {
                        $_SESSION['fail'] = 'Fail';
                        $errors = OrderLine::getErrores();
                        $this->pages->render('Order/Order', ['errors' => $errors]);
                    }
                }
                $this->pages->render('Layout/principal');

            } else {
                $_SESSION['fail'] = 'Fail'; // Si no hay datos
            }
        } else {
            $this->pages->render('Order/order');
        }
    }

    public function AllOrderLine(){
        if(!isset($_SESSION['user'])){
            $this->pages->render('Auth/loginForm');
        }else{
            $orderLine = $this->orderLineService->AllOrderLine();
            $this->pages->render('Order/orderLine', ['orderLine' => $orderLine]);
        }
    }
}