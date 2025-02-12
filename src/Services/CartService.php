<?php

namespace Services;

use Repositories\CartRepository;

class CartService
{
    private CartRepository $cartRepository;

    public function __construct()
    {
        $this->cartRepository = new CartRepository();
    }

    public function isProductInCart(int $productId, int $userId): bool
    {
        return $this->cartRepository->isProductInCart($productId, $userId);
    }

    public function getProductQuantity(int $productId, int $userId): int
    {
        return $this->cartRepository->getProductQuantity($productId, $userId);
    }

    public function increaseProductQuantity(int $productId, int $userId): void
    {
        $this->cartRepository->increaseProductQuantity($productId, $userId);
    }

    public function decreaseProductQuantity(int $productId, int $userId): void
    {
        $this->cartRepository->decreaseProductQuantity($productId, $userId);
    }

    public function addProductToCart(int $productId, int $userId): void
    {
        $this->cartRepository->addProductToCart($productId, $userId);
    }

    public function removeProductFromCart(int $productId, int $userId): void
    {
        $this->cartRepository->removeProductFromCart($productId, $userId);
    }

    public function getCartItemsByUserId(int $userId): array
    {
        return $this->cartRepository->getCartItemsByUserId($userId);
    }

    public function updateProductQuantity(int $productId, int $userId, int $quantity): void
    {
        $this->cartRepository->updateProductQuantity($productId, $userId, $quantity);
    }

    public function clearCart(int $userId): void
    {
        $this->cartRepository->clearCart($userId);
    }

    public function addNewProduct(int $productId, int $userId, int $cantidad): void
    {
        $this->cartRepository->addNewProduct($productId, $userId, $cantidad);
    }

    
}
