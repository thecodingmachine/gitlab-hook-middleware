<?php
namespace TheCodingMachine\GitlabHook\Model\Base;

use TheCodingMachine\GitlabHook\Model\AbstractObject;

class Branch extends AbstractObject
{

    /**
     * Project constructor.
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
    public function getDescription(): string
    {
        return $this->getAttribute('description');
    }

    /**
     * @return string
     */
    public function getWebUrl(): string
    {
        return $this->getAttribute('web_url');
    }

    /**
     * @return string|null
     */
    public function getAvatarUrl(): ?string
    {
        return $this->getAttribute('avatar_url');
    }

    /**
     * @return string
     */
    public function getGitSshUrl(): string
    {
        return $this->getAttribute('git_ssh_url');
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
    public function getNamespace(): string
    {
        return $this->getAttribute('namespace');
    }

    /**
     * @return int
     */
    public function getVisibilityLevel(): int
    {
        return $this->getAttribute('visibility_level');
    }

    /**
     * @return string
     */
    public function getPathWithNamespace(): string
    {
        return $this->getAttribute('path_with_namespace');
    }

    /**
     * @return string
     */
    public function getDefaultBranch(): string
    {
        return $this->getAttribute('default_branch');
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
    public function getUrl(): string
    {
        return $this->getAttribute('url');
    }

    /**
     * @return string
     */
    public function getSshUrl(): string
    {
        return $this->getAttribute('ssh_url');
    }

    /**
     * @return string
     */
    public function getHttpUrl(): string
    {
        return $this->getAttribute('http_url');
    }
}
