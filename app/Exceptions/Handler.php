<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    // use Throwable - you should NOT import Throwable class as a trait here. You need to just import it above the class
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            return $this->handleApiException($request, $exception);
        }

        // تحديد ما إذا كان الطلب من لوحة التحكم أم من الواجهة الأمامية
        $isAdmin = str_starts_with($request->path(), 'admin') ||
            str_starts_with($request->path(), 'dashboard');

        // تخصيص مسار صفحة الخطأ
        if ($isAdmin) {
            $viewPrefix = 'errors.admin.';
        } else {
            $viewPrefix = 'errors.';
        }

        // التعامل مع أنواع الأخطاء المختلفة
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->view($viewPrefix . '404', [], 404);
        }

        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException) {
            return response()->view($viewPrefix . '403', [], 403);
        }

        // ... التعامل مع أنواع أخرى من الأخطاء

        return parent::render($request, $exception);
    }

    /**
     * Handle API exceptions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleApiException($request, Throwable $exception)
    {
        $exception = $this->prepareException($exception);

        if ($exception instanceof \Illuminate\Http\Exceptions\HttpResponseException) {
            $exception = $exception->getResponse();
        }

        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;

        $response = [
            'success' => false,
            'message' => $statusCode == 500 ? 'حدث خطأ في الخادم' : $exception->getMessage()
        ];

        if (config('app.debug')) {
            $response['exception'] = get_class($exception);
            $response['trace'] = $exception->getTrace();
        }

        return response()->json($response, $statusCode);
    }
}