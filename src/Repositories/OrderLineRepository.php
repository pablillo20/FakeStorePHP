<?php

namespace Repositories;

use Lib\DataBase;
use Models\OrderLine;
use PDO;
use PDOException;


class OrderLineRepository
{

    private DataBase $db;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function CreateOrderLine(OrderLine $orderLine): bool
    {
        try {
            // Prepara la consulta SQL para insertar un pedido
            $insert = $this->db->prepare("INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades) VALUES (:pedido_id, :producto_id, :unidades)");
        
            // Vincula los valores del objeto OrderLine a los parámetros de la consulta
            $insert->bindValue(':pedido_id', $orderLine->getPedidoId(), PDO::PARAM_INT);
            $insert->bindValue(':producto_id', $orderLine->getProductoId(), PDO::PARAM_STR);
            $insert->bindValue(':unidades', $orderLine->getUnidades(), PDO::PARAM_STR);
            
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

    public function AllOrderLine(): array
    {
        try{
            $query = $this->db->prepare("SELECT * FROM lineas_pedidos");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            error_log("Error al obtener los pedidos: ".$e->getMessage());
            return [];
        }finally{
            if(isset($query)){
                $query->closeCursor();
            }
        }
    }

}
