<?php
namespace TheCodingMachine\GitlabHook\Model\Event;

use TheCodingMachine\GitlabHook\EventInterface;
use TheCodingMachine\GitlabHook\Model\AbstractObject;
use TheCodingMachine\GitlabHook\Model\Base\Build;
use TheCodingMachine\GitlabHook\Model\Base\Commit;
use TheCodingMachine\GitlabHook\Model\Base\Project;
use TheCodingMachine\GitlabHook\Model\Base\User;

class Pipeline extends AbstractObject implements EventInterface
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
     * @var Commit
     */
    private $commit;

    /**
     * @var Build[]
     */
    private $builds = [];

    /**
     * Pipeline constructor.
     *
     * @param mixed[] $payload
     */
    public function __construct(array $payload)
    {
        parent::__construct($payload);
        $this->user = new User($this->getAttribute('user'));
        $this->project = new Project($this->getAttribute('project'));
        $this->commit = new Commit($this->getAttribute('commit'));
        foreach ($this->getAttribute('builds') as $build) {
            $this->builds[] = new Build($build);
        }
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
    public function getRef(): string
    {
        return $this->getAttribute('ref', 'object_attributes');
    }

    /**
     * @return bool
     */
    public function getTag(): bool
    {
        return $this->getAttribute('tag', 'object_attributes');
    }

    /**
     * @return string
     */
    public function getSha(): string
    {
        return $this->getAttribute('sha', 'object_attributes');
    }

    /**
     * @return string
     */
    public function getBeforeSha(): string
    {
        return $this->getAttribute('before_sha', 'object_attributes');
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->getAttribute('status', 'object_attributes');
    }

    /**
     * @return string[]
     */
    public function getStages(): array
    {
        return $this->getAttribute('stages', 'object_attributes');
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
    public function getFinishedAt(): \DateTimeImmutable
    {
        return $this->getDateTimeAttribute('finished_at', 'object_attributes');
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->getAttribute('duration', 'object_attributes');
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
     * @return Commit
     */
    public function getCommit(): Commit
    {
        return $this->commit;
    }

    /**
     * @return Build[]
     */
    public function getBuilds(): array
    {
        return $this->builds;
    }
}
