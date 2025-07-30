<?php

use App\Http\Middleware\CheckLicence;
use App\Http\Middleware\CheckRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middlewar Aliases Licence
        $middleware->alias([
            'checklicence' => CheckLicence::class,
            'checkrole' => CheckRole::class,
        ]);


    })
    ->withExceptions(function (Exceptions $exceptions) {
        //c'est moi qui est ajouter pour ignorer les erreur http 419
        $exceptions->respond(function (Response $response) {
            if ($response->getStatusCode() === 419) {
                return redirect('/')
                ->with('message', 'La session a expiré, veuillez réessayer.');
            }
            return $response;
        });
        
    })->create();
