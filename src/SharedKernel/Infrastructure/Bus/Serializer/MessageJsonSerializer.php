<?php

namespace App\SharedKernel\Infrastructure\Bus\Serializer;

use App\SharedKernel\Domain\Event\Message;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface as MessageSerializerInterface;

class MessageJsonSerializer implements MessageSerializerInterface
{
    public function __construct(private $allMessages)
    {
    }

    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        $headers = $encodedEnvelope['headers'];

        $message = json_decode($body, true);
        if (!array_key_exists('payload', $message) || !array_key_exists('metadata', $message)) {
            throw new MessageDecodingFailedException('Invalid message format');
        }

        $stamps = unserialize($headers['stamps']);
        $routingKey = $stamps[AmqpStamp::class]->getRoutingKey();

        foreach ($this->allMessages as $msg) {
            if ($msg->name() === $routingKey) {
                return new Envelope($msg->withAddedData($message['payload'], $message['metadata']), $stamps ?? null);
            }
        }

        throw new \Exception('Message map not found');
    }


    public function encode(Envelope $envelope): array
    {
        $message = $envelope->getMessage();

        if (!$message instanceof Message) {
            throw new \Exception(sprintf('Serializer does not support message of type %s.', $message::class));
        }

        $allStamps = array_map(fn($stamps) => array_shift($stamps), $envelope->all());

        return [
            'body' => json_encode($message->toArray()),
            'headers' => [
                'stamps' => serialize($allStamps)
            ]
        ];
    }
}
