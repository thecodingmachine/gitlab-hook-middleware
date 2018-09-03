<?php
namespace TheCodingMachine\GitlabHook\Model\Event;

use TheCodingMachine\GitlabHook\EventInterface;
use TheCodingMachine\GitlabHook\Model\AbstractObject;
use TheCodingMachine\GitlabHook\Model\Base\Commit;
use TheCodingMachine\GitlabHook\Model\Base\Project;
use TheCodingMachine\GitlabHook\Model\Base\Repository;

class TagPush extends AbstractObject implements EventInterface
{

    /**
     * @var Project
     */
    private $project;

    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var Commit[]
     */
    private $commits = [];

    /**
     * TagPush constructor.
     *
     * @param mixed[] $payload
     */
    public function __construct(array $payload)
    {
        parent::__construct($payload);
        $this->project = new Project($this->getAttribute('project'));
        $this->repository = new Repository($this->getAttribute('repository'));
        foreach ($this->getAttribute('commits') as $commit) {
            $this->commits[] = new Commit($commit);
        }
    }

    /**
     * @return string
     */
    public function getBefore(): string
    {
        return $this->getAttribute('before');
    }

    /**
     * @return string
     */
    public function getAfter(): string
    {
        return $this->getAttribute('after');
    }

    /**
     * @return string
     */
    public function getRef(): string
    {
        return $this->getAttribute('ref');
    }

    /**
     * @return string
     */
    public function getCheckoutSha(): string
    {
        return $this->getAttribute('checkout_sha');
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
     * @return Repository
     */
    public function getRepository(): Repository
    {
        return $this->repository;
    }

    /**
     * @return Commit[]
     */
    public function getCommits(): array
    {
        return $this->commits;
    }

    /**
     * @return int
     */
    public function getTotalCommitsCount(): int
    {
        return $this->getAttribute('total_commits_count');
    }
}
