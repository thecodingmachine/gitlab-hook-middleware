<?php
namespace TheCodingMachine\GitlabHook\Model\Event;

use TheCodingMachine\GitlabHook\EventInterface;
use TheCodingMachine\GitlabHook\Model\AbstractObject;
use TheCodingMachine\GitlabHook\Model\Base\ObjectAttributes;
use TheCodingMachine\GitlabHook\Model\Base\Project;
use TheCodingMachine\GitlabHook\Model\Base\User;
use TheCodingMachine\GitlabHook\Model\Base\Wiki;

class WikiPage extends AbstractObject implements EventInterface
{

    /**
     * @var User
     */
    private $user;

    /**
     * @var Project
     */
    private $project;

    /**
     * @var Wiki
     */
    private $wiki;

    /**
     * TagPush constructor.
     *
     * @param mixed[] $payload
     */
    public function __construct(array $payload)
    {
        parent::__construct($payload);
        $this->user = new User($this->getAttribute('user'));
        $this->project = new Project($this->getAttribute('project'));
        $this->wiki = new Wiki($this->getAttribute('wiki'));
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getAttribute('title', 'object_attributes');
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->getAttribute('content', 'object_attributes');
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->getAttribute('format', 'object_attributes');
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->getAttribute('message', 'object_attributes');
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->getAttribute('slug', 'object_attributes');
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->getAttribute('url', 'object_attributes');
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->getAttribute('action', 'object_attributes');
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * @return Wiki
     */
    public function getWiki(): Wiki
    {
        return $this->wiki;
    }
}
