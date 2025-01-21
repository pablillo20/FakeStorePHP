<?php

namespace Models;

class Product
{
    protected static array $errores = [];

    public function __construct(
        private int $id ,
        private int $categoria_id,
        private string $nombre,
        private string $descripcion,
        private float $precio,
        private int $stock,
        private string $oferta,
        private string $fecha,
        private string $imagen
    ) {}

    // SETTERS
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setCategoriaId(int $categoria_id): void
    {
        $this->categoria_id = $categoria_id;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function setOferta(string $oferta): void
    {
        $this->oferta = $oferta;
    }

    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }

    public function setImagen(string $imagen): void
    {
        $this->imagen = $imagen;
    }

    // GETTERS
    public function getId()
    {
        return $this->id;
    }

    public function getCategoriaId()
    {
        return $this->categoria_id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getOferta()
    {
        return $this->oferta;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function validation(): bool
    {
        if(empty($this->categoria_id)){
            self::$errores['categoria_id'] = "Categoria es obligatorio";
        }

        if (empty($this->nombre)) {
            self::$errores['nombre'] = 'El nombre es obligatorio';
        }

        if (empty($this->descripcion)) {
            self::$errores['descripcion'] = 'La descripción es obligatoria';
        }

        if ($this->precio <= 0) {
            self::$errores['precio'] = 'El precio debe ser mayor a cero';
        }

        if (!isset($this->stock) || $this->stock === '') {
            self::$errores['stock'] = 'El stock es obligatorio';
        } elseif ($this->stock < 0) {
            self::$errores['stock'] = 'El stock no puede ser negativo';
        }
        

        if($this->oferta < 0){
            self::$errores['oferta'] = "La oferta no puede ser negativa";
        }

        if (empty($this->fecha)) {
            self::$errores['fecha'] = 'La fecha es obligatoria';
        }


        return empty(self::$errores);
    }

    public function validationEdit(): bool
    {
        if(empty($this->categoria_id)){
            self::$errores['categoria_id'] = "Categoria es obligatorio";
        }

        if (empty($this->nombre)) {
            self::$errores['nombre'] = 'El nombre es obligatorio';
        }

        if (empty($this->descripcion)) {
            self::$errores['descripcion'] = 'La descripción es obligatoria';
        }

        if ($this->precio <= 0) {
            self::$errores['precio'] = 'El precio debe ser mayor a cero';
        }

        if (!isset($this->stock) || $this->stock === '') {
            self::$errores['stock'] = 'El stock es obligatorio';
        } elseif ($this->stock < 0) {
            self::$errores['stock'] = 'El stock no puede ser negativo';
        }
        

        if($this->oferta < 0){
            self::$errores['oferta'] = "La oferta no puede ser negativa";
        }

        return empty(self::$errores);
    }

    public function sanitize(): void
    {
        $this->nombre = htmlspecialchars($this->nombre, ENT_QUOTES, 'UTF-8');
        $this->descripcion = htmlspecialchars($this->descripcion, ENT_QUOTES, 'UTF-8');
        $this->oferta = htmlspecialchars($this->oferta, ENT_QUOTES, 'UTF-8');
        $this->fecha = htmlspecialchars($this->fecha, ENT_QUOTES, 'UTF-8');
        $this->imagen = htmlspecialchars($this->imagen, ENT_QUOTES, 'UTF-8');
    }


    public static function fromArray(array $data): Product
    {
        $product = new Product(
            $data['id'] ?? 0,
            (int)$data['categoria_id'] ?? "",
            $data['nombre'] ?? "",
            $data['descripcion']?? "",
            (float)$data['precio'] ?? "",
            (int)$data['stock'] ?? "",
            $data['oferta'] ?? "",
            $data['fecha'] ?? "",
            $data['imagen'] ?? ""
        );

        return $product;
    }


    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'categoria_id' => $this->getCategoriaId(),
            'nombre' => $this->getNombre(),
            'descripcion' => $this->getDescripcion(),
            'precio' => $this->getPrecio(),
            'stock' => $this->getStock(),
            'oferta' => $this->getOferta(),
            'fecha' => $this->getFecha(),
            'imagen' => $this->getImagen()
        ];
    }

    public static function getErrores(): array
    {
        return self::$errores;
    }
}
