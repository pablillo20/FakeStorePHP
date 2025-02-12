<?php

namespace Models;

class Cart {
    
    public function __construct(
        private int $id, 
        private int $usuario_id, 
        private int $producto_id,
        private int $cantidad
    ) {}



    public function getId(): int {
        return $this->id;
    }

    public function getUsuarioId(): int {
        return $this->usuario_id;
    }

    public function getProductoId(): int {
        return $this->producto_id;
    }

    public function getCantidad(): int {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): void {
        $this->cantidad = $cantidad;
    }
}
