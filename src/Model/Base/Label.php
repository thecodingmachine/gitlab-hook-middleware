<?php
namespace TheCodingMachine\GitlabHook\Model\Base;

use TheCodingMachine\GitlabHook\Model\AbstractObject;

class Label extends AbstractObject
{

    /**
     * Repository constructor.
     *
     * @param mixed[] $payload
     */
    public function __construct(array $payload)
    {
        parent::__construct($payload);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getAttribute('title');
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->getAttribute('color');
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->getAttribute('project_id');
    }

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
     * @return bool
     */
    public function getTemplate(): bool
    {
        return $this->getAttribute('template');
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->getAttribute('description');
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->getAttribute('type');
    }

    /**
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->getAttribute('group_id');
    }
}
