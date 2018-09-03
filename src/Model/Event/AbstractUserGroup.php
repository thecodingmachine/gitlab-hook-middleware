<?php
namespace TheCodingMachine\GitlabHook\Model\Event;

use TheCodingMachine\GitlabHook\EventInterface;
use TheCodingMachine\GitlabHook\Model\AbstractObject;

abstract class AbstractUserGroup extends AbstractObject implements EventInterface
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
    public function getGroupAccess(): string
    {
        return $this->getAttribute('group_access');
    }

    /**
     * @return string
     */
    public function getGroupName(): string
    {
        return $this->getAttribute('group_name');
    }

    /**
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->getAttribute('group_id');
    }

    /**
     * @return string
     */
    public function getGroupPath(): string
    {
        return $this->getAttribute('group_path');
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->getAttribute('user_email');
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->getAttribute('user_name');
    }

    /**
     * @return string
     */
    public function getUserUsername(): string
    {
        return $this->getAttribute('user_username');
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->getAttribute('user_id');
    }
}
