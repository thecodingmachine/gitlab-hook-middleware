<?php
namespace TheCodingMachine\GitlabHook\Model\Event;

class UserRename extends AbstractUser
{
    /**
     * @return string
     */
    public function getOldUsername(): string
    {
        return $this->getAttribute('old_username');
    }
}
