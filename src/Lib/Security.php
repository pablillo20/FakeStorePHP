<?php

namespace Lib;

use Controllers\ErrorController;
use Firebase\JWT\JWT;
use Services\UserService;
use Firebase\JWT\Key;

// para almacenar las rutas que configuremos desde el archivo index.php
class Security
{
    final public static function encryptPassw(string $passw)
    {
        return password_hash($passw, PASSWORD_DEFAULT);
    }

    final public static function validatePassw(string $passw, string $passwhash)
    {
        return password_verify($passw, $passwhash);
    }

    final public static function secretKey()
    {
        return $_ENV['SECRET_KEY'];
    }

    final public static function crearToken(string $key, array $data): string
    {
        $time =  strtotime('now');
        $token = array(
            'iat' => $time,
            'exp' => $time + 3600,
            'data' => $data
        );
        return JWT::encode($token, $key, 'HS256');
    }

    final public static function crearTokenRecuperacion(string $key, array $data): string
    {
        $time = strtotime('now');
        $token = array(
            'iat' => $time,
            'exp' => $time + 1800, // 30 minutos
            'data' => $data
        );
        return JWT::encode($token, $key, 'HS256');
    }

    final public static function validateToken($token): bool
    {
        try {
            $info = JWT::decode($token, new Key(Security::secretKey(), 'HS256'));
            $exp = $info->exp;
            $email = $info->data[0];

            if ($exp < time()) {
                return false;
            }

            $usuario = new UserService();
            $user = $usuario->login($email);

            return $user && $user->getToken() === $token;
        } catch (\Exception $e) {
            return false;
        }
    }

    final public static function validateTokenRecuperacion($token): bool
    {
        try {
            $info = JWT::decode($token, new Key(Security::secretKey(), 'HS256'));
            $exp = $info->exp;
            $email = $info->data[0];

            if ($exp < time()) {
                return false;
            }

            $usuario = new UserService();
            $user = $usuario->getUserByEmail($email);

            return $user && $user->getTokenRecuperacion() === $token;
        } catch (\Exception $e) {
            return false;
        }
    }
}
