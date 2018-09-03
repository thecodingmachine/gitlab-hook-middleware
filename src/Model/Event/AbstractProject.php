<?php
namespace TheCodingMachine\GitlabHook\Model\Event;

use TheCodingMachine\GitlabHook\EventInterface;
use TheCodingMachine\GitlabHook\Model\AbstractObject;

abstract class AbstractProject extends AbstractObject implements EventInterface
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
     * @return string
     */
    public function getOwnerEmail(): string
    {
        return $this->getAttribute('owner_email');
    }

    /**
     * @return string
     */
    public function getOwnerName(): string
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
     * @return string
     */
    public function getPathWithNamespace(): string
    {
        return $this->getAttribute('path_with_namespace');
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->getAttribute('project_id');
    }

    /**
     * @return string
     */
    public function getProjectVisibility(): string
    {
        return $this->getAttribute('project_visibility');
    }
}
