# Proteção contra Ataques CSRF

## O que foi implementado

A aplicação foi protegida contra ataques **CSRF (Cross-Site Request Forgery)** através da implementação de um sistema de tokens seguros.

## Como funciona

### 1. **Serviço de Tokens CSRF** (`src/Service/CsrfTokenService.php`)

O serviço gerencia os tokens de segurança com os seguintes métodos:

- `generateToken()`: Gera um novo token (32 bytes em hexadecimal) e o armazena na sessão
- `getToken()`: Obtém o token atual da sessão
- `validateToken(string $token)`: Valida se o token fornecido é igual ao armazenado (usa `hash_equals` para evitar timing attacks)
- `regenerateToken()`: Regenera o token após uma ação bem-sucedida

### 2. **Formulários com Token**

Todos os formulários (`login-form.php` e `formulario.php`) agora incluem:

```php
<input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>" />
```

### 3. **Validação nos Controladores**

Os seguintes controladores foram modificados para validar o token CSRF:

- `LoginController` - Valida login
- `NewVideoController` - Valida criação de novo vídeo
- `UpdateVideoController` - Valida atualização de vídeo

**Fluxo de validação:**
1. Extrai o token do corpo da requisição
2. Valida usando `CsrfTokenService::validateToken()`
3. Se inválido, retorna erro e redireciona
4. Se válido, processa a requisição
5. Após sucesso, regenera o token

## Exemplo de uso

```php
use Alura\Mvc\Service\CsrfTokenService;

// Na view - gerar token
$token = CsrfTokenService::generateToken();
?>
<input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>" />

// No controlador - validar token
$csrfToken = $queryParsedBody['csrf_token'] ?? '';
if (!CsrfTokenService::validateToken($csrfToken)) {
    $this->addErrorMessage('Token de segurança inválido. Tente novamente.');
    return new Response(302, ['Location' => '/novo-video']);
}
```

## Benefícios

✅ Previne ataques CSRF onde sites maliciosos tentam fazer requisições em nome do usuário  
✅ Token único por sessão  
✅ Validação usando `hash_equals` (protege contra timing attacks)  
✅ Regeneração após ações bem-sucedidas  
✅ Implementação simples e reutilizável

## Próximos passos (recomendações)

- Adicionar proteção CSRF nos demais formulários (delete, logout)
- Implementar rate limiting para tentativas de login
- Adicionar logs de tentativas falhadas de CSRF
- Usar SameSite cookies para proteção adicional (https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie/SameSite)
