<?php

namespace Controllers;

use Lib\Pages;
use Lib\PDF;
use Models\Order;
use Lib\PhpMail;
use Services\OrderService;
use Exception;


class OrderController
{
    private PDF $PDF;
    private Pages $pages;
    private PhpMail $PhpMail;
    private OrderService $orderService;

    public function __construct()
    {
        $this->PDF = new PDF();
        $this->PhpMail = new PhpMail();
        $this->pages = new Pages();
        $this->orderService = new OrderService();
    }


    public function createOrder()
    {

        if (!isset($_SESSION['user'])) {
            $this->pages->render('Auth/loginForm');
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['data'])) {
                    $precioTotal = 0;
                    foreach ($_SESSION['cart'] as $product) {
                        $precioTotal += $product['precio'] * $product['quantity'];
                    }

                    $order = new Order(
                        null,
                        $_SESSION['user']['id'],
                        $_POST['data']['provincia'],
                        $_POST['data']['localidad'],
                        $_POST['data']['direccion'],
                        $precioTotal,
                        'confirmado',
                        date('Y-m-d'),
                        date('H:i:s')
                    );
                    $order->sanitize();
                    if ($order->validation()) {
                        try {
                            $this->orderService->createOrder($order);
                            $_SESSION['order_id'] = $this->orderService->getLastInsertId();
                            $this->pages->render('Layout/principal');
                            $correo = $_SESSION['user']['email'];
                            $pdfContent = $this->PDF->generarPDF($order);
                            $this->PhpMail->enviarCorreo($correo, "Compra de la Tienda", "Gracias por Su compra", $pdfContent);
                        } catch (Exception $e) {
                            $_SESSION['create'] = 'Fail';
                            $_SESSION['errors'] = $e->getMessage();
                        }
                    } else {
                        $_SESSION['register'] = 'Fail';
                        $errors = Order::getErrores();
                        $_SESSION["fallos"] = $errors;
                        header('Location:'. BASE_URL . 'createOrder');
                       
                    }
                } else {
                    $_SESSION['register'] = 'Fail'; // Si no hay datos
                }
            } else {
                $this->pages->render('Order/order');
            }
        }
    }

    // Funcion para mostrar todos los pedidos del usuario
    public function showOrders()
    {
        if(!isset($_SESSION['user'])){
            $this->pages->render('Auth/loginForm');
        }else{
            $orders = $this->orderService->getOrdersByUser($_SESSION['user']['id']);
            $this->pages->render('Order/showOrders', ['orders' => $orders]);
        }
        
    }
}