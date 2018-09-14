<?php
namespace TheCodingMachine\GitlabHook\Model\Event;

use TheCodingMachine\GitlabHook\EventInterface;
use TheCodingMachine\GitlabHook\Model\AbstractObject;

abstract class AbstractGroup extends AbstractObject implements EventInterface
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
    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    /**
     * @return string|null
     */
    public function getOwnerEmail(): ?string
    {
        return $this->getAttribute('owner_email');
    }

    /**
     * @return string|null
     */
    public function getOwnerName(): ?string
    {
        return $this->getAttribute('owner_name');
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->getAttribute('path');
    }

    /**
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->getAttribute('group_id');
    }
}
