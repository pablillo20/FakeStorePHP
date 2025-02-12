<?php

namespace Controllers;

use Lib\Pages;
use Models\OrderLine;
use Services\OrderLineService;
use Services\ProductService;
use Services\CartService;
use Exception;

class OrderLineController
{
    private Pages $pages;
    private OrderLineService $orderLineService;
    private ProductService $productService;
    private CartService $cartService;

    public function __construct()
    {
        // Inicializa las páginas y los servicios de líneas de pedido, productos y carrito
        $this->pages = new Pages();
        $this->orderLineService = new OrderLineService();
        $this->productService = new ProductService();
        $this->cartService = new CartService();
    }

    public function createOrderLine()
    {
        // Verifica si la solicitud es POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifica si el ID del usuario está presente
            if (isset($_SESSION['user']['id']) && isset($_SESSION['order_id'])) {
                $userId = $_SESSION['user']['id'];
                $orderId = $_SESSION['order_id'];
                $cartItems = $this->cartService->getCartItemsByUserId($userId);

                foreach ($cartItems as $product) {
                    $orderLine = new OrderLine(
                        null,
                        $orderId,
                        $product['producto_id'],
                        $product['cantidad']
                    );
                    $orderLine->sanitize();
                    // Valida los datos de la línea de pedido
                    if ($orderLine->validation()) {
                        try {
                            $this->orderLineService->createOrderLine($orderLine);
                            // Restar el stock del producto
                            $this->productService->decreaseStock($product['producto_id'], $product['cantidad']);
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
                $this->cartService->clearCart($userId);
                $this->pages->render('Layout/principal');
            } else {
                $_SESSION['fail'] = 'Fail'; // Si no hay datos
            }
        } else {
            $this->pages->render('Order/order');
        }
    }

    public function AllOrderLine()
    {
        // Verifica si el usuario ha iniciado sesión
        if (!isset($_SESSION['user'])) {
            $this->pages->render('Auth/loginForm');
        } else {
            $orderLine = $this->orderLineService->AllOrderLine();
            $this->pages->render('Order/orderLine', ['orderLine' => $orderLine]);
        }
    }
}