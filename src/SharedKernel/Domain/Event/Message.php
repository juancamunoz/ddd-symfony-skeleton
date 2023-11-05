<?php

namespace App\SharedKernel\Domain\Event;

abstract class Message
{
    private const MESSAGE_COMPANY_NAME = 'company_name';

    public function __construct(private array $payload = [], private array $metadata = [])
    {
    }

    public function withAddedData(array $payload, array $metadata): self
    {
        return new static($payload, $metadata);
    }

    public function payload(): array
    {
        return $this->payload;
    }

    public function metadata(): array
    {
        return $this->metadata;
    }

    protected function get(string $key): mixed
    {
        return $this->payload[$key];
    }

    abstract protected function boundedContext(): string;
    abstract protected function messageType(): string;
    abstract protected function messageName(): string;

    public function name(): string
    {
        //Eg: company_name.auth.domain_event.user_was_created
        return sprintf(
            '%s.%s.%s.%s',
            self::MESSAGE_COMPANY_NAME,
            $this->boundedContext(),
            $this->messageType(),
            $this->messageName()
        );
    }

    public function toArray(): array
    {
        return [
            'payload' => $this->payload,
            'metadata' => $this->metadata
        ];
    }
}
