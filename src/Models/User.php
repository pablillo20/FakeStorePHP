<?php

namespace Models;

class User
{

    protected static array $errores = [];

    public function __construct(
        private int|null $id,
        private string $name,
        private string $lastName,
        private string $email,
        private string $password,
        private string $role,
        private bool $confirmado,
        private string $token,
        private string $token_exp
        ) {}



        
        public function setConfirmado(bool $confirmado): void
        {
        $this->confirmado = $confirmado;
        }

        public function setToken(string $token): void
        {
        $this->token = $token;
        }

        public function setTokenExp(int $token_exp): void
        {
        $this->token_exp = $token_exp;
        }

        public function getConfirmado(): bool
        {
        return $this->confirmado;
        }

        public function getToken(): string
        {
        return $this->token;
        }

        public function getTokenExp(): int
        {
        return $this->token_exp;
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

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setRol(string $role): void
    {
        $this->role = $role;
    }


    // GETTERS

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRol()
    {
        return $this->role;
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

        if (empty($this->name)) {
            self::$errores[] = "The name is required.";
        }

        if (empty($this->lastName)) {
            self::$errores[] = "The last name is required.";
        }

        if (empty($this->email)) {
            self::$errores[] = "The email is required.";
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$errores[] = "The email is not valid.";
        }

        if (empty($this->password)) {
            self::$errores[] = "The password is required.";
        } elseif (strlen($this->password) < 6) {
            self::$errores[] = "The password must be at least 6 characters.";
        }

        if (empty($this->role)) {
            self::$errores[] = "The role is required.";
        }

        return empty(self::$errores);
    }
    public function validationLogin(): bool
    {
        self::$errores = [];

        if (empty($this->email)) {
            self::$errores[] = "The email is required.";
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$errores[] = "The email is not valid.";
        }

        return empty(self::$errores);
    }

    // Sanitize data
    public function sanitize(): void
    {
        $this->name = filter_var($this->name, FILTER_SANITIZE_STRING);
        $this->lastName = filter_var($this->lastName, FILTER_SANITIZE_STRING);
        $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
        $this->password = filter_var($this->password, FILTER_SANITIZE_STRING);
        $this->role = filter_var($this->role, FILTER_SANITIZE_STRING);
        $this->confirmado = filter_var($this->confirmado, FILTER_SANITIZE_STRING);
        $this->token = filter_var($this->token, FILTER_SANITIZE_STRING);
        $this->token_exp = filter_var($this->token_exp, FILTER_SANITIZE_STRING);
    }

    public static function fromArray(array $data): User
    {
        return new User(
            id: $data['id'] ?? null,
            name: $data['nombre'] ?? '',
            lastName: $data['apellido'] ?? '',
            email: $data['email'] ?? '',
            password: $data['password'] ?? '',
            role: $data['rol'] ?? 'usuario',
            confirmado: $data['confirmado'] ?? False,
            token: $data['token'] ?? '' ,
            token_exp: $data['token_exp'] ?? 0,
        );
    }
}
