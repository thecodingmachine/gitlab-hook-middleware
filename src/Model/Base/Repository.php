<?php
namespace TheCodingMachine\GitlabHook\Model\Base;

use TheCodingMachine\GitlabHook\Model\AbstractObject;

class Repository extends AbstractObject
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
     * @return string
     */
    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->getAttribute('url');
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
    public function getHomepage(): string
    {
        return $this->getAttribute('homepage');
    }

    /**
     * @return string
     */
    public function getGitHttpUrl(): string
    {
        return $this->getAttribute('git_http_url');
    }

    /**
     * @return string
     */
    public function getGitSshUrl(): string
    {
        return $this->getAttribute('git_ssh_url');
    }

    /**
     * @return int
     */
    public function getVisibilityLevel(): int
    {
        return $this->getAttribute('visibility_level');
    }
}
