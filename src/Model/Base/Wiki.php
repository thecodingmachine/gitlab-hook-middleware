<?php
namespace TheCodingMachine\GitlabHook\Model\Base;

use TheCodingMachine\GitlabHook\Model\AbstractObject;

class Wiki extends AbstractObject
{

    /**
     * Wiki constructor.
     *
     * @param array $payload
     */
    public function __construct(array $payload)
    {
        parent::__construct($payload);
    }

    /**
     * @return string
     */
    public function getWebUrl(): string
    {
        return $this->getAttribute('web_url');
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
}
