# Log Request Package

Este pacote Laravel registra todas as requisições HTTP recebidas, incluindo o URL, método, dados enviados e cabeçalhos da requisição. É ideal para fins de depuração e monitoramento de tráfego.

## Índice

- [Instalação](#instalação)
- [Configuração](#configuração)
- [Uso](#uso)
  - [Middleware em Rotas Específicas](#middleware-em-rotas-específicas)
  - [Middleware Global](#middleware-global)
- [Exemplo de Log](#exemplo-de-log)
- [Testes](#testes)
- [Licença](#licença)

## Instalação

Para instalar o pacote, basta utilizar o **Composer**:

```bash
composer require request-log/log-request-package
```

O pacote será registrado automaticamente graças ao **Laravel Package Auto-Discovery**.

## Configuração

Se quiser personalizar as configurações do pacote, como logar ou não os cabeçalhos das requisições, você pode publicar o arquivo de configuração:

```bash
php artisan vendor:publish --tag=logrequest-config
```

Isso criará um arquivo de configuração `config/logrequest.php` onde você poderá ajustar as opções.

## Uso

### Middleware em Rotas Específicas

Para usar o middleware em rotas específicas, basta aplicá-lo diretamente no seu arquivo de rotas (`routes/web.php` ou `routes/api.php`):

```php
Route::middleware('log.request')->group(function () {
    Route::get('/minha-rota', [MinhaController::class, 'meuMetodo']);
    // Outras rotas...
});
```

### Middleware Global

Se você quiser aplicar o middleware a todas as rotas (de forma global), pode registrar o middleware no grupo de middlewares `web` ou `api` em `app/Http/Kernel.php`:

```php
protected $middlewareGroups = [
    'web' => [
        // Outros middlewares...
        \RequestLog\LogRequestPackage\Middleware\LogRequestMiddleware::class,
    ],
];
```

Ou, alternativamente, o middleware pode ser aplicado globalmente via o `ServiceProvider` do pacote, descomentando a linha no arquivo `LogRequestServiceProvider.php`:

```php
$router->pushMiddlewareToGroup('web', LogRequestMiddleware::class);
```

## Exemplo de Log

O log padrão da requisição será registrado no arquivo de log padrão do Laravel (`storage/logs/laravel.log`). Aqui está um exemplo de saída do log:

```plaintext
[2024-09-11 12:34:56] local.INFO: Requisição recebida {
    "url": "http://meusite.com/minha-rota",
    "metodo": "POST",
    "dados": {
        "nome": "João",
        "email": "joao@example.com"
    },
    "cabecalhos": {
        "host": ["meusite.com"],
        "content-type": ["application/json"],
        "user-agent": ["Mozilla/5.0 ..."],
        "accept": ["*/*"],
        // Outros cabeçalhos...
    }
}
```

## Testes

Para testar o pacote, você pode criar um projeto Laravel de teste e usar o middleware em suas rotas. Se quiser automatizar os testes, adicione testes de middleware nas suas rotas usando o **PHPUnit** ou qualquer framework de testes compatível com Laravel.

Exemplo de teste básico:

```php
public function test_log_request_middleware()
{
    $response = $this->get('/minha-rota');

    // Verificar se a resposta está correta
    $response->assertStatus(200);

    // Verificar se os logs foram gravados corretamente
    // Isso pode ser feito lendo o arquivo de logs e procurando as entradas de log
}
```

## Licença

Este pacote é open-source e está licenciado sob a licença MIT. Para mais detalhes, consulte o arquivo [LICENSE](LICENSE).
