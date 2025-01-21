<?php

namespace Repositories;

use Lib\DataBase;
use Models\Order;
use PDO;
use PDOException;


class OrderRepository
{

    private DataBase $db;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function CreateOrder(Order $order): bool
    {
        try {
            // Prepara la consulta SQL para insertar un pedido
            $insert = $this->db->prepare("INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) VALUES (:usuario_id, :provincia, :localidad, :direccion, :coste, :estado, :fecha, :hora)");
        
            // Vincula los valores del objeto Order a los parámetros de la consulta
            $insert->bindValue(':usuario_id', $order->getUsuarioId(), PDO::PARAM_INT);
            $insert->bindValue(':provincia', $order->getProvincia(), PDO::PARAM_STR);
            $insert->bindValue(':localidad', $order->getLocalidad(), PDO::PARAM_STR);
            $insert->bindValue(':direccion', $order->getDireccion(), PDO::PARAM_STR);
            $insert->bindValue(':coste', $order->getCoste(), PDO::PARAM_STR);
            $insert->bindValue(':estado', $order->getEstado(), PDO::PARAM_STR);
            $insert->bindValue(':fecha', $order->getFecha(), PDO::PARAM_STR);
            $insert->bindValue(':hora', $order->getHora(), PDO::PARAM_STR);

            
            // Ejecuta la consulta de inserción
            $insert->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error al crear el pedido: " . $e->getMessage());
            return false;
        } finally {
            if (isset($insert)) {
                $insert->closeCursor();
            }
        }
    }

    public function getLastInsertId(): int
    {
        try {
            return (int)$this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error al obtener el último ID insertado: " . $e->getMessage());
            return 0;
        }
    }

    public function getOrdersByUserId(int $userId): array
    {
        try {
            $select = $this->db->prepare("SELECT * FROM pedidos LEFT JOIN lineas_pedidos  ON pedidos.id = lineas_pedidos.pedido_id WHERE pedidos.usuario_id = :usuario_id;");
            $select->bindValue(':usuario_id', $userId, PDO::PARAM_INT);
            $select->execute();
            $orders = $select->fetchAll(PDO::FETCH_ASSOC);
            return $orders;
        } catch (PDOException $e) {
            error_log("Error al obtener los pedidos del usuario: " . $e->getMessage());
            return [];
        } finally {
            if (isset($select)) {
                $select->closeCursor();
            }
        }
    }
}
