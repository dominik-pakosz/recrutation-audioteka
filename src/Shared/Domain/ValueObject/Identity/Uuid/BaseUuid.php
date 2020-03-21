<?php

namespace App\Shared\Domain\ValueObject\Identity\Uuid;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface as RamseyUuid;

abstract class BaseUuid implements UuidInterface
{
    /** @var RamseyUuid */
    private $uuid;

    protected function __construct(string $uuid = null)
    {
        $this->uuid = $uuid ?  $this->fromString($uuid) : $this->generate();
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function equals(UuidInterface $uuid): bool
    {
        $uuidString = $uuid->toString();
        $ramseyUuid = Uuid::fromString($uuidString);

        return $this->uuid->equals($ramseyUuid);
    }

    private function generate(): RamseyUuid
    {
        return Uuid::uuid4();
    }

    private function fromString(string $uuid): RamseyUuid
    {
        return Uuid::fromString($uuid);
    }
}