<?php
namespace TheCodingMachine\GitlabHook\Model\Event;

use TheCodingMachine\GitlabHook\EventInterface;
use TheCodingMachine\GitlabHook\Model\AbstractObject;
use TheCodingMachine\GitlabHook\Model\Base\Branch;
use TheCodingMachine\GitlabHook\Model\Base\Change;
use TheCodingMachine\GitlabHook\Model\Base\Commit;
use TheCodingMachine\GitlabHook\Model\Base\Label;
use TheCodingMachine\GitlabHook\Model\Base\ObjectAttributes;
use TheCodingMachine\GitlabHook\Model\Base\Project;
use TheCodingMachine\GitlabHook\Model\Base\Repository;
use TheCodingMachine\GitlabHook\Model\Base\User;

class MergeRequest extends AbstractObject implements EventInterface
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
     * @var Label[]
     */
    private $labels = [];

    /**
     * @var Change
     */
    private $change;

    /**
     * @var Branch
     */
    private $source;

    /**
     * @var Branch
     */
    private $target;

    /**
     * @var Commit
     */
    private $lastCommit;

    /**
     * @var User
     */
    private $assignee;

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
        $this->repository = new Repository($this->getAttribute('repository'));
        foreach ($this->getAttribute('labels') as $label) {
            $this->labels[] = new Label($label);
        }
        $this->change = new Change($this->getAttribute('changes'));
        $this->source = new Branch($this->getAttribute('source', 'object_attributes'));
        $this->target = new Branch($this->getAttribute('target', 'object_attributes'));
        $this->lastCommit = new Commit($this->getAttribute('last_commit', 'object_attributes'));
        $this->assignee = new User($this->getAttribute('assignee', 'object_attributes'));
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
     * @return int
     */
    public function getId(): int
    {
        return $this->getAttribute('id', 'object_attributes');
    }

    /**
     * @return string
     */
    public function getTargetBranch(): string
    {
        return $this->getAttribute('target_branch', 'object_attributes');
    }

    /**
     * @return string
     */
    public function getSourceBranch(): string
    {
        return $this->getAttribute('source_branch', 'object_attributes');
    }

    /**
     * @return int
     */
    public function getSourceProjectId(): int
    {
        return $this->getAttribute('source_project_id', 'object_attributes');
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
    public function getAssigneeId(): int
    {
        return $this->getAttribute('assignee_id', 'object_attributes');
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getAttribute('title', 'object_attributes');
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
     * @return string
     */
    public function getMergeState(): string
    {
        return $this->getAttribute('merge_status', 'object_attributes');
    }

    /**
     * @return int
     */
    public function getTargetProjectId(): int
    {
        return $this->getAttribute('target_project_id', 'object_attributes');
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
    public function getDescription(): string
    {
        return $this->getAttribute('description', 'object_attributes');
    }

    /**
     * @return Branch
     */
    public function getSource(): Branch
    {
        return $this->source;
    }

    /**
     * @return Branch
     */
    public function getTarget(): Branch
    {
        return $this->target;
    }

    /**
     * @return Commit
     */
    public function getLastCommit(): Commit
    {
        return $this->lastCommit;
    }

    /**
     * @return boolean
     */
    public function getWorkInProgress(): bool
    {
        return $this->getAttribute('work_in_progress', 'object_attributes');
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
    public function getAssignee(): User
    {
        return $this->assignee;
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
        return $this->change;
    }
}
