<?php
namespace TheCodingMachine\GitlabHook\Model\Event;

use TheCodingMachine\GitlabHook\EventInterface;
use TheCodingMachine\GitlabHook\Model\AbstractObject;
use TheCodingMachine\GitlabHook\Model\Base\ChangeRepository;
use TheCodingMachine\GitlabHook\Model\Base\Project;

class RepositoryUpdate extends AbstractObject implements EventInterface
{

    /**
     * @var Project
     */
    private $project;

    /**
     * @var ChangeRepository[]
     */
    private $changes = [];

    /**
     * Repository constructor.
     *
     * @param mixed[] $payload
     */
    public function __construct(array $payload)
    {
        parent::__construct($payload);
        $this->project = new Project($this->getAttribute('project'));
        foreach ($this->getAttribute('changes') as $change) {
            $this->changes[] = new ChangeRepository($change);
        }
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->getAttribute('user_id');
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
    public function getUserEmail(): string
    {
        return $this->getAttribute('user_email');
    }

    /**
     * @return string
     */
    public function getUserAvatar(): string
    {
        return $this->getAttribute('user_avatar');
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->getAttribute('project_id');
    }

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * @return ChangeRepository[]
     */
    public function getChanges(): array
    {
        return $this->changes;
    }

    /**
     * @return string[]
     */
    public function getRefs(): array
    {
        return $this->getAttribute('refs');
    }
}
