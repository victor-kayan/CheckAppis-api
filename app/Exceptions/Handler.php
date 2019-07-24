<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    public function render($request, Exception $exception)
    {
        $error = [
             'success' => false,
             'message' => 'Erro ao executar esta operação, entre em contato com o administrador do sistema',
         ];

        if ($exception instanceof ValidationException) {
            $error['message'] = $exception->validator->getMessageBag()->first();
            $statusCode = 422;

            return response()->json([
                'message' => $error['message'],
            ], $statusCode);
        }

        return parent::render($request, $exception);
    }
}
