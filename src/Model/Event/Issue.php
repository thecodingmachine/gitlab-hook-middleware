<?php
namespace TheCodingMachine\GitlabHook\Model\Event;

use TheCodingMachine\GitlabHook\EventInterface;
use TheCodingMachine\GitlabHook\Model\AbstractObject;
use TheCodingMachine\GitlabHook\Model\Base\Change;
use TheCodingMachine\GitlabHook\Model\Base\Label;
use TheCodingMachine\GitlabHook\Model\Base\Project;
use TheCodingMachine\GitlabHook\Model\Base\Repository;
use TheCodingMachine\GitlabHook\Model\Base\User;

class Issue extends AbstractObject implements EventInterface
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
     * @var Repository
     */
    private $repository;

    /**
     * @var User[]
     */
    private $assignees = [];

    /**
     * @var User
     */
    private $assignee;

    /**
     * @var Label[]
     */
    private $labels = [];

    /**
     * @var Change
     */
    private $changes;

    /**
     * Event constructor.
     *
     * @param mixed[] $payload
     */
    public function __construct(array $payload)
    {
        parent::__construct($payload);
        $this->user = new User($this->getAttribute('user'));
        $this->project = new Project($this->getAttribute('project'));
        $this->repository = new Repository($this->getAttribute('repository'));
        foreach ($this->getAttribute('assignees') as $assignee) {
            $this->assignees[] = new User($assignee);
        }
        $this->assignee = new User($this->getAttribute('assignee'));
        foreach ($this->getAttribute('labels') as $label) {
            $this->labels[] = new Label($label);
        }
        $this->changes = new Change($this->getAttribute('changes'));
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->getAttribute('id', 'object_attributes');
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getAttribute('title', 'object_attributes');
    }

    /**
     * @return int[]
     */
    public function getAssigneeIds(): array
    {
        return $this->getAttribute('assignee_ids', 'object_attributes');
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->getAttribute('author_id', 'object_attributes');
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->getAttribute('project_id', 'object_attributes');
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->getDateTimeAttribute('created_at', 'object_attributes');
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->getDateTimeAttribute('updated_at', 'object_attributes');
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->getAttribute('position', 'object_attributes');
    }

    /**
     * @return string|null
     */
    public function getBranchName(): ?string
    {
        return $this->getAttribute('branch_name', 'object_attributes');
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->getAttribute('description', 'object_attributes');
    }

    /**
     * @return int|null
     */
    public function getMilestoneId(): ?int
    {
        return $this->getAttribute('milestone_id', 'object_attributes');
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->getAttribute('state', 'object_attributes');
    }

    /**
     * @return int
     */
    public function getIid(): int
    {
        return $this->getAttribute('iid', 'object_attributes');
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
     * @return Repository
     */
    public function getRepository(): Repository
    {
        return $this->repository;
    }

    /**
     * @return User[]
     */
    public function getAssignees(): array
    {
        return $this->assignees;
    }

    /**
     * @return Label[]
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    /**
     * @return Change
     */
    public function getChanges(): Change
    {
        return $this->changes;
    }
}
