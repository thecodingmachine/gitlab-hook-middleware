<?php
namespace TheCodingMachine\GitlabHook\Model\Event;

use TheCodingMachine\GitlabHook\EventInterface;
use TheCodingMachine\GitlabHook\Model\AbstractObject;

abstract class AbstractKey extends AbstractObject implements EventInterface
{
    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->getDateTimeAttribute('created_at');
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->getDateTimeAttribute('updated_at');
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->getAttribute('username');
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->getAttribute('key');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->getAttribute('id');
    }
}
