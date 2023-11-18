<?php

namespace App\SharedKernel\Infrastructure\Symfony\Listener;

use App\SharedKernel\Domain\Aggregate\Exception\AggregateNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

class JsonResponseTransformerOnKernelExceptionListener implements EventSubscriberInterface
{
    private const EXCEPTION_CODE_MAPPER = [
        AggregateNotFoundException::class => 404
    ];

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => 'onKernelException'];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HttpException) {
            $event->setResponse(new JsonResponse([
                'error_code' => $exception->getStatusCode(),
                'message' => $exception->getMessage()
            ], $exception->getStatusCode()));
        }

        if ($exception instanceof HandlerFailedException) {
            $exception = $exception?->getPrevious() ?? $exception;
        }

        if (in_array($exception::class, array_keys(self::EXCEPTION_CODE_MAPPER))) {
            $code = self::EXCEPTION_CODE_MAPPER[$exception::class];
            $event->setResponse(new JsonResponse([
                'error_code' => $code,
                'message' => $exception->getMessage()
            ], $code));
        }
    }
}
