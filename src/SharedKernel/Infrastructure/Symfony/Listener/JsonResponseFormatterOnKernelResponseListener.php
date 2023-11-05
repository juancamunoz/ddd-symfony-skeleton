<?php

namespace App\SharedKernel\Infrastructure\Symfony\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class JsonResponseFormatterOnKernelResponseListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::RESPONSE => 'onKernelResponse'];
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        if ($response->getStatusCode() > 299) {
            return;
        }

        $content = json_decode($response->getContent(), true);

        $response->setContent(json_encode(['data' => $content]));
    }
}
