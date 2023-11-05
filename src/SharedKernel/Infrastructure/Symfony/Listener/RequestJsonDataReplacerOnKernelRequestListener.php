<?php

namespace App\SharedKernel\Infrastructure\Symfony\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestJsonDataReplacerOnKernelRequestListener implements EventSubscriberInterface
{
    private const CONTENT_TYPE_APPLICATION_JSON = 'application/json';

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::REQUEST => 'onKernelRequest'];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if ($event->getRequest()->headers->get('content-type') !== self::CONTENT_TYPE_APPLICATION_JSON) {
            return;
        }

        $data = json_decode($event->getRequest()->getContent(), true);

        $event->getRequest()->request->replace($data);
    }
}
