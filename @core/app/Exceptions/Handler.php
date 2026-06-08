<?php

namespace App\Exceptions;

use App\Services\AuditLogger;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Routine exceptions that would otherwise flood the audit trail
     * (checklist 3.a wants application errors & exceptions, not 404 noise).
     */
    protected $auditExempt = [
        ValidationException::class,
        NotFoundHttpException::class,
        ModelNotFoundException::class,
        AuthenticationException::class,
    ];

    public function report(Throwable $exception)
    {
        $this->auditException($exception);

        parent::report($exception);
    }

    protected function auditException(Throwable $exception)
    {
        foreach ($this->auditExempt as $exempt) {
            if ($exception instanceof $exempt) {
                return;
            }
        }

        AuditLogger::log('exception', [
            'level' => 'error',
            'description' => get_class($exception) . ': ' . $exception->getMessage(),
            'meta' => [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ],
        ]);
    }

    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            if ($exception->getStatusCode() == 404) {
                return response()->view('frontend.pages.404');
            }
            if ($exception->getStatusCode() == 500 ) {
                return response()->view('frontend.pages.500');
            }
        }
        return parent::render($request, $exception);
    }


}
