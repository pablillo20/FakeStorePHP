<?php

namespace Models;

class Category
{

    protected static array $errores = [];

    public function __construct(
        private int|null $id,
        private string $name,
    ) {}

    // GETTERS

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }


    // SETTERS

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public static function getErrores(): array
    {
        return self::$errores;
    }

    public static function setErrores(array $errores): void
    {
        self::$errores = $errores;
    }




    public function validation(): bool
    {
        self::$errores = [];

        if (!$this->name) {
            self::$errores[] = "The name is required.";
        }

        return empty(self::$errores);
    }


    public function sanitize(): void
    {
        $this->name = filter_var($this->name, FILTER_SANITIZE_STRING);
    }

    public static function fromArray(array $data): Category
    {
        $category = new Category(
            id: $data['id'] ?? null,
            name: $data['nombre'] ?? ''
        );
        return $category;
    }
}
