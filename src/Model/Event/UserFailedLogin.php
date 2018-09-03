<?php
namespace TheCodingMachine\GitlabHook\Model\Event;

class UserFailedLogin extends AbstractUser
{
    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->getAttribute('state');
    }
}
