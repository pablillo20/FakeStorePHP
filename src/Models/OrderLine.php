<?php

namespace Models;

class OrderLine
{
    protected static array $errores = [];

    public function __construct(
        private int|null $id = null,
        private int $pedido_id,
        private int $producto_id,
        private int $unidades
    ) {}

    // GETTERS
    public function getId(): int|null {
        return $this->id;
    }

    public function getPedidoId(): int {
        return $this->pedido_id;
    }

    public function getProductoId(): int {
        return $this->producto_id;
    }

    public function getUnidades(): int {
        return $this->unidades;
    }

    // SETTERS
    public function setId(int|null $id): void {
        $this->id = $id;
    }

    public function setPedidoId(int $pedido_id): void {
        $this->pedido_id = $pedido_id;
    }

    public function setProductoId(int $producto_id): void {
        $this->producto_id = $producto_id;
    }

    public function setUnidades(int $unidades): void {
        $this->unidades = $unidades;
    }

    // Errores
    public static function getErrores(): array {
        return self::$errores;
    }

    public static function setErrores(array $errores): void {
        self::$errores = $errores;
    }

    // Sanitización
    public function sanitize(): void {
        $this->id = filter_var($this->id, FILTER_VALIDATE_INT);
        $this->pedido_id = filter_var($this->pedido_id, FILTER_VALIDATE_INT);
        $this->producto_id = filter_var($this->producto_id, FILTER_VALIDATE_INT);
        $this->unidades = filter_var($this->unidades, FILTER_VALIDATE_INT);
    }

    // Validación
    public function validation(): bool {
        self::$errores = [];

        if (!filter_var($this->pedido_id, FILTER_VALIDATE_INT) || $this->pedido_id <= 0) {
            self::$errores[] = "El ID del pedido debe ser un número entero positivo.";
        }

        if (!filter_var($this->producto_id, FILTER_VALIDATE_INT) || $this->producto_id <= 0) {
            self::$errores[] = "El ID del producto debe ser un número entero positivo.";
        }

        if (!filter_var($this->unidades, FILTER_VALIDATE_INT) || $this->unidades <= 0) {
            self::$errores[] = "Las unidades deben ser un número entero positivo.";
        }

        return empty(self::$errores);
    }

    // Crear instancia desde un array
    public static function fromArray(array $data): OrderLine {
        return new OrderLine(
            $data['id'] ?? null,
            $data['pedido_id'] ?? 0,
            $data['producto_id'] ?? 0,
            $data['unidades'] ?? 0
        );
    }

    // Convertir instancia a array
    public function toArray(): array {
        return [
            'id' => $this->id,
            'pedido_id' => $this->pedido_id,
            'producto_id' => $this->producto_id,
            'unidades' => $this->unidades,
        ];
    }
}
