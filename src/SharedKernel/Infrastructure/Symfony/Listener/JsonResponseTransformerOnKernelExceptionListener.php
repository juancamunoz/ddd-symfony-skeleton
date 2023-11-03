<?php

namespace App\Shared\Infrastructure\Symfony\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class JsonResponseTransformerOnKernelExceptionListener implements EventSubscriberInterface
{
    private const HTTP_CODE_EXCEPTION_MAPPER = [
        NotFoundHttpException::class => 404
    ];

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => 'onKernelException'];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (in_array($exception::class, array_keys(self::HTTP_CODE_EXCEPTION_MAPPER))) {
            $event->setResponse(new JsonResponse([
                'message' => $exception->getMessage()
            ], self::HTTP_CODE_EXCEPTION_MAPPER[$exception::class]));
        }
    }
}
