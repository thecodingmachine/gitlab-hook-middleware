<?php
namespace TheCodingMachine\GitlabHook\Model\Base;

use TheCodingMachine\GitlabHook\Model\AbstractObject;

class User extends AbstractObject
{

    /**
     * Issue constructor.
     *
     * @param array $payload
     *
     * @throws \TheCodingMachine\GitlabHook\GitlabHookException
     */
    public function __construct(array $payload)
    {
        parent::__construct($payload);
    }

    /**
     * @return string
     * @throws \TheCodingMachine\GitlabHook\GitlabHookException
     */
    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    /**
     * @return string
     * @throws \TheCodingMachine\GitlabHook\GitlabHookException
     */
    public function getUsername(): string
    {
        return $this->getAttribute('username');
    }

    /**
     * @return string
     * @throws \TheCodingMachine\GitlabHook\GitlabHookException
     */
    public function getAvatarUrl(): string
    {
        return $this->getAttribute('avatar_url');
    }
}
