<?php

namespace Controllers;

use Lib\Pages;
use Exception;
use Services\ProductService;
use Services\CartService;

class CartController
{
    private Pages $pages;
    private ProductService $productService;
    private CartService $cartService;

    public function __construct()
    {
        // Inicializa las páginas y los servicios
        $this->pages = new Pages();
        $this->productService = new ProductService();
        $this->cartService = new CartService();
    }

    public function AddCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)$_POST['product_id'];

            // Verifica si el usuario está logueado
            $isLoggedIn = isset($_SESSION['user']['id']);
            $userId = $isLoggedIn ? $_SESSION['user']['id'] : null;

            // Obtiene el producto por su ID
            $product = $this->productService->getProductById($productId);

            if ($product) {
                // Verifica si hay stock disponible
                if ($product->getStock() > 0) {
                    if ($isLoggedIn) {
                        // Usuario logueado: maneja el carrito en la base de datos
                        if ($this->cartService->isProductInCart($productId, $userId)) {
                            if ($this->cartService->getProductQuantity($productId, $userId) < $product->getStock()) {
                                $this->cartService->increaseProductQuantity($productId, $userId);
                                $_SESSION['success'] = 'Producto añadido al carrito correctamente.';
                            } else {
                                $_SESSION['error'] = 'No hay suficiente stock disponible.';
                            }
                        } else {
                            $this->cartService->addProductToCart($productId, $userId);
                            $_SESSION['success'] = 'Producto añadido al carrito correctamente.';
                        }
                    } else {
                        // Usuario no logueado: maneja el carrito en sesión
                        if (!isset($_SESSION['cart'])) {
                            $_SESSION['cart'] = [];
                        }

                        if (isset($_SESSION['cart'][$productId])) {
                            if ($_SESSION['cart'][$productId]['quantity'] < $product->getStock()) {
                                $_SESSION['cart'][$productId]['quantity']++;
                                $_SESSION['message'] = 'Producto añadido.';
                            } else {
                                $_SESSION['message'] = 'No se puede añadir más del stock disponible.';
                            }
                        } else {
                            $_SESSION['cart'][$productId] = $product->toArray();
                            $_SESSION['cart'][$productId]['quantity'] = 1;
                            $_SESSION['message'] = 'Producto añadido.';
                        }
                    }
                } else {
                    $_SESSION[$isLoggedIn ? 'error' : 'message'] = 'Producto sin stock disponible.';
                }
            } else {
                $_SESSION[$isLoggedIn ? 'error' : 'message'] = 'Producto no encontrado.';
            }

            if ($isLoggedIn) {
                header('Location: ' . BASE_URL . '/FilterProducts');
                exit();
            } else {
                header('Location: ' . BASE_URL . '/FilterProducts');
                exit();
            }
        };
    }

    public function ShowCart()
    {
        // Verifica si el usuario ha iniciado sesión
        if (!isset($_SESSION['user'])) {
            // Usuario no logueado: obtiene el carrito desde la sesión
            $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        } else {
            // Usuario logueado: obtiene el carrito desde la base de datos
            $cartItems = $this->cartService->getCartItemsByUserId($_SESSION['user']['id']);
        }

        $this->pages->render('Cart/showCart', ['cartItems' => $cartItems]);
    }

    public function updateCart()
    {
        // Verifica si la solicitud es POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int) $_POST['product_id'];

            // Verifica si el usuario está logueado
            $isLoggedIn = isset($_SESSION['user']['id']);
            $userId = $isLoggedIn ? $_SESSION['user']['id'] : null;
            $action = $_POST['action'];
            $productStock = $this->productService->getProductById($productId);

            if ($isLoggedIn) {
                // Usuario logueado: maneja el carrito en la base de datos
                // Verifica si el producto está en el carrito
                if ($this->cartService->isProductInCart($productId, $userId)) {

                    // Aumenta la cantidad del producto en el carrito
                    if ($action === 'increase' && $this->cartService->getProductQuantity($productId, $userId) < $productStock->getStock()) {
                        $this->cartService->increaseProductQuantity($productId, $userId);
                    }
                    // Disminuye la cantidad del producto en el carrito
                    elseif ($action === 'decrease' && $this->cartService->getProductQuantity($productId, $userId) > 1) {
                        $this->cartService->decreaseProductQuantity($productId, $userId);
                    }
                    // Elimina el producto del carrito si la cantidad es 1
                    elseif ($action === 'decrease' && $this->cartService->getProductQuantity($productId, $userId) == 1) {
                        $this->cartService->removeProductFromCart($productId, $userId);
                    }
                }
            } else {
                // Usuario no logueado: maneja el carrito en la sesión
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                if (isset($_SESSION['cart'][$productId])) {
                    if ($action === 'increase' && $_SESSION['cart'][$productId]['quantity'] < $productStock->getStock()) {
                        $_SESSION['cart'][$productId]['quantity']++;
                    } elseif ($action === 'decrease' && $_SESSION['cart'][$productId]['quantity'] > 1) {
                        $_SESSION['cart'][$productId]['quantity']--;
                    } elseif ($action === 'decrease' && $_SESSION['cart'][$productId]['quantity'] == 1) {
                        unset($_SESSION['cart'][$productId]);
                    }
                }
            }
        }

        // Redirige a la página del carrito
        if ($isLoggedIn) {
            $cartItems = $this->cartService->getCartItemsByUserId($userId);
        } else {
            $cartItems = $_SESSION['cart'] ?? [];
        }

        $this->pages->render('Cart/showCart', ['cartItems' => $cartItems]);
    }



    // Añadir carrito a usuario
    public function addSessionCart($userId)
    {
        // Verifica si el carrito existe en la sesión
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            // Itera sobre los productos del carrito en sesión
            foreach ($_SESSION['cart'] as $productId => $productData) {
                // Verifica si el producto ya está en el carrito de la base de datos para el usuario logueado
                if ($this->cartService->isProductInCart($productId, $userId)) {
                    // Si el producto ya está en el carrito, simplemente actualiza la cantidad
                    $currentQuantity = $this->cartService->getProductQuantity($productId, $userId);
                    $newQuantity = $currentQuantity + $productData['quantity'];

                    // Verifica que no exceda el stock disponible
                    $product = $this->productService->getProductById($productId);
                    if ($newQuantity <= $product->getStock()) {
                        $this->cartService->updateProductQuantity($productId, $userId, $newQuantity);
                    } else {
                        // Si el stock no es suficiente, puedes mostrar un mensaje o ajustar la cantidad al stock disponible
                        $this->cartService->updateProductQuantity($productId, $userId, $product->getStock());
                    }
                } else {
                    // Si el producto no está en el carrito de la base de datos, lo agrega
                    if ($productData['quantity'] <= $productData['stock']) {
                        $this->cartService->addNewProduct($productId, $userId, $productData['quantity']);
                    }
                }
            }

            // Después de sincronizar el carrito, podemos limpiar el carrito de la sesión
            unset($_SESSION['cart']);
        }
    }
}
