<?php

namespace Controllers;

use Lib\Pages;
use Lib\PDF;
use Models\Order;
use Lib\PhpMail;
use Services\OrderService;
use Services\CartService;
use Services\ProductService;

use Exception;

class OrderController
{
    private PDF $PDF;
    private Pages $pages;
    private PhpMail $PhpMail;
    private OrderService $orderService;
    private CartService $cartService;
    private ProductService $productService;

    public function __construct()
    {
        // Inicializa las páginas, el servicio de PDF, el correo y el servicio de pedidos
        $this->PDF = new PDF();
        $this->PhpMail = new PhpMail();
        $this->pages = new Pages();
        $this->orderService = new OrderService();
        $this->cartService = new CartService();
        $this->productService = new ProductService();
    }

    public function createOrder()
{
    if (!isset($_SESSION['user'])) {
        $this->pages->render('Auth/loginForm');
        exit();
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['data'])) {
                $userId = $_SESSION['user']['id'];
                $cartItems = $this->cartService->getCartItemsByUserId($userId);
                $Total = $this->calculateTotalPrice($cartItems);
                $order = new Order(
                    null,
                    $userId,
                    $_POST['data']['provincia'],
                    $_POST['data']['localidad'],
                    $_POST['data']['direccion'],
                    $Total,
                    'confirmado',
                    date('Y-m-d'),
                    date('H:i:s')
                );
                $order->sanitize();

                if ($order->validation()) {
                    try {
                        $this->orderService->createOrder($order);
                        $orderId = $this->orderService->getLastInsertId(); 
                        $_SESSION['order_id'] = $orderId;

                       

                        // Reducir stock de cada producto en el carrito
                        foreach ($cartItems as $item) {
                            $this->productService->decreaseStock($item['producto_id'], $item['cantidad']);
                        }

                        $this->pages->render('Layout/principal');
                        $correo = $_SESSION['user']['email'];
                        $pdfContent = $this->PDF->generarPDF($order, $cartItems);
                        $this->PhpMail->enviarCorreo($correo, "Compra de la Tienda", "Gracias por Su compra", $pdfContent);
                        $this->cartService->clearCart($userId); // Vaciar el carrito
                    } catch (Exception $e) {
                        $_SESSION['create'] = 'Fail';
                        $_SESSION['errors'] = $e->getMessage();
                    }
                } else {
                    $_SESSION['register'] = 'Fail';
                    $errors = Order::getErrores();
                    $_SESSION["fallos"] = $errors;
                    header('Location:' . BASE_URL . 'createOrder');
                }
            } else {
                $_SESSION['register'] = 'Fail'; // Si no hay datos
            }
        } else {
            $userId = $_SESSION['user']['id'];
            $cartItems = $this->cartService->getCartItemsByUserId($userId);
            $precioTotal = $this->calculateTotalPrice($cartItems);
            $this->pages->render('Order/order', ['precio' => $precioTotal]);
        }
    }
}


    private function calculateTotalPrice(array $cartItems): float {
        $total = 0.0; 
        foreach ($cartItems as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        return $total;
    }

    // Función para mostrar todos los pedidos del usuario
    public function showOrders()
    {
        // Verifica si el usuario ha iniciado sesión
        if(!isset($_SESSION['user'])){
            $this->pages->render('Auth/loginForm');
        }else{
            $orders = $this->orderService->getOrdersByUser($_SESSION['user']['id']);
            $this->pages->render('Order/showOrders', ['orders' => $orders]);
        }
    }
}