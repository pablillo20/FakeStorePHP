<?php

namespace Models;

class Order
{
    protected static array $errores = [];

    public function __construct(
        private int|null $id,
        private int $usuario_id,
        private string $provincia,
        private string $localidad,
        private string $direccion,
        private float $coste,
        private string $estado,
        private string $fecha,
        private string $hora
    ) {}

    // SETTERS

    public function setEstado(string $estado): void {
        $this->estado = $estado;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function setUsuarioId(int $usuario_id): void {
        $this->usuario_id = $usuario_id;
    }

    public function setProvincia(string $provincia): void {
        $this->provincia = $provincia;
    }

    public function setLocalidad(string $localidad): void {
        $this->localidad = $localidad;
    }

    public function setDireccion(string $direccion): void {
        $this->direccion = $direccion;
    }

    public function setCoste(float $coste): void {
        $this->coste = $coste;
    }

    public function setFecha(string $fecha): void {
        $this->fecha = $fecha;
    }

    public function setHora(string $hora): void {
        $this->hora = $hora;
    }

    // GETTERS
    public function getEstado(): string {
        return $this->estado;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getUsuarioId(): int {
        return $this->usuario_id;
    }

    public function getProvincia(): string {
        return $this->provincia;
    }

    public function getLocalidad(): string {
        return $this->localidad;
    }

    public function getDireccion(): string {
        return $this->direccion;
    }

    public function getCoste(): float {
        return $this->coste;
    }

    public function getFecha(): string {
        return $this->fecha;
    }

    public function getHora(): string {
        return $this->hora;
    }

    public static function getErrores(): array {
        return self::$errores;
    }

    public static function setErrores(array $errores): void {
        self::$errores = $errores;
    }

    public function sanitize(): void {
        $this->id = filter_var($this->id, FILTER_VALIDATE_INT);
        $this->usuario_id = filter_var($this->usuario_id, FILTER_VALIDATE_INT);
        $this->provincia = htmlspecialchars(strip_tags($this->provincia));
        $this->localidad = htmlspecialchars(strip_tags($this->localidad));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->coste = filter_var($this->coste, FILTER_VALIDATE_FLOAT);
        $this->fecha = htmlspecialchars(strip_tags($this->fecha));
        $this->hora = htmlspecialchars(strip_tags($this->hora));
    }
    
    public function validation(): bool {
        self::$errores = [];
    
        if (!$this->usuario_id ) {
            self::$errores[] = "El ID de usuario no es válido.";
        }
        if (empty($this->provincia)) {
            self::$errores['provincia'] = "La provincia es obligatoria.";
        }
        if (empty($this->localidad)) {
            self::$errores['localidad'] = "La localidad es obligatoria.";
        }
        if (empty($this->direccion)) {
            self::$errores['direccion'] = "La dirección es obligatoria.";
        }
        if (!$this->coste ) {
            self::$errores[] = "El coste no es válido.";
        }
        if (empty($this->fecha)) {
            self::$errores[] = "La fecha es obligatoria.";
        }
        if (empty($this->hora)) {
            self::$errores[] = "La hora es obligatoria.";
        }
    
        return empty(self::$errores);
    }
    

    public static function fromArray(array $data): Order {
        return new Order(
            $data['id'] ?? null,
            $data['usuario_id'],
            $data['provincia'],
            $data['localidad'],
            $data['direccion'],
            $data['coste'],
            $data['estado'],
            $data['fecha'],
            $data['hora']
        );
    }
}
