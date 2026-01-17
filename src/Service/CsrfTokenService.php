<?php

namespace Alura\Mvc\Service;

class CsrfTokenService {
    private const TOKEN_LENGTH = 32;
    private const SESSION_KEY = 'csrf_token';

    /**
     * Gera um novo token CSRF se não existir um na sessão
     */
    public static function generateToken(): string {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(self::TOKEN_LENGTH));
        }
        
        return $_SESSION[self::SESSION_KEY];
    }

    /**
     * Obtém o token CSRF da sessão
     */
    public static function getToken(): string {
        return $_SESSION[self::SESSION_KEY] ?? '';
    }

    /**
     * Valida o token CSRF fornecido
     */
    public static function validateToken(string $token): bool {
        if (empty($_SESSION[self::SESSION_KEY])) {
            return false;
        }

        return hash_equals($_SESSION[self::SESSION_KEY], $token);
    }

    /**
     * Regenera o token CSRF (útil após validação bem-sucedida)
     */
    public static function regenerateToken(): string {
        $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(self::TOKEN_LENGTH));
        return $_SESSION[self::SESSION_KEY];
    }
}
