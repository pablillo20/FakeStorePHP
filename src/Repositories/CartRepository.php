<?php

namespace Repositories;

use PDO;
use Lib\DataBase;

class CartRepository
{
    private DataBase $db;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function isProductInCart(int $productId, int $userId): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM carrito WHERE producto_id = :product_id AND usuario_id = :user_id');
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function getProductQuantity(int $productId, int $userId): int
    {
        $stmt = $this->db->prepare('SELECT cantidad FROM carrito WHERE producto_id = :product_id AND usuario_id = :user_id');
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() ?? 0;
    }

    public function increaseProductQuantity(int $productId, int $userId): void
    {
        $stmt = $this->db->prepare('UPDATE carrito SET cantidad = cantidad + 1 WHERE producto_id = :product_id AND usuario_id = :user_id');
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function decreaseProductQuantity(int $productId, int $userId): void
    {
        $stmt = $this->db->prepare('UPDATE carrito SET cantidad = cantidad - 1 WHERE producto_id = :product_id AND usuario_id = :user_id');
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function addProductToCart(int $productId, int $userId): void
    {
        $stmt = $this->db->prepare('INSERT INTO carrito (usuario_id, producto_id, cantidad) VALUES (:user_id, :product_id, 1)');
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function removeProductFromCart(int $productId, int $userId): void
    {
        $stmt = $this->db->prepare('DELETE FROM carrito WHERE producto_id = :product_id AND usuario_id = :user_id');
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function clearCart(int $userId): void
    {
        $stmt = $this->db->prepare('DELETE FROM carrito WHERE usuario_id = :user_id');
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getCartItemsByUserId(int $userId): array
    {
        $stmt = $this->db->prepare('
            SELECT carrito.*, productos.nombre, productos.descripcion, productos.precio, productos.imagen, productos.stock, productos.oferta
            FROM carrito
            JOIN productos ON carrito.producto_id = productos.id
            WHERE carrito.usuario_id = :user_id
        ');
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateProductQuantity(int $productId, int $userId, int $quantity): void
    {
        // Actualiza la cantidad del producto en el carrito de la base de datos para el usuario
        $query = "UPDATE carrito SET cantidad = :quantity WHERE usuario_id = :user_id AND producto_id = :product_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function addNewProduct(int $productId, int $userId, int $cantidad): void
    {
        $stmt = $this->db->prepare('INSERT INTO carrito (usuario_id, producto_id, cantidad) VALUES (:user_id, :product_id, :cantidad)');
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->execute();
    }
}
