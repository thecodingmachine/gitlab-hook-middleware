<?php
namespace TheCodingMachine\GitlabHook\Model\Event;

use TheCodingMachine\GitlabHook\EventInterface;
use TheCodingMachine\GitlabHook\GitlabHookException;
use TheCodingMachine\GitlabHook\Model\AbstractObject;
use TheCodingMachine\GitlabHook\Model\Base\Commit;
use TheCodingMachine\GitlabHook\Model\Base\Project;
use TheCodingMachine\GitlabHook\Model\Base\Repository;
use TheCodingMachine\GitlabHook\Model\Base\User;

class Build extends AbstractObject implements EventInterface
{

    /**
     * @var mixed[]
     */
    private $user;

    /**
     * @var mixed[]
     */
    private $commit;

    /**
     * @var Repository
     */
    private $repository;

    /**
     * Pipeline constructor.
     *
     * @param mixed[] $payload
     */
    public function __construct(array $payload)
    {
        parent::__construct($payload);
        $this->user = $this->getAttribute('user');
        $this->commit = $this->getAttribute('commit');
        $this->repository = new Repository($this->getAttribute('repository'));
    }

    /**
     * @return string
     */
    public function getRef(): string
    {
        return $this->getAttribute('ref');
    }

    /**
     * @return bool
     */
    public function getTag(): bool
    {
        return $this->getAttribute('tag');
    }

    /**
     * @return string
     */
    public function getSha(): string
    {
        return $this->getAttribute('sha');
    }

    /**
     * @return string
     */
    public function getBeforeSha(): string
    {
        return $this->getAttribute('before_sha');
    }

    /**
     * @return int
     */
    public function getBuildId(): int
    {
        return $this->getAttribute('build_id');
    }

    /**
     * @return string
     */
    public function getBuildName(): string
    {
        return $this->getAttribute('build_name');
    }

    /**
     * @return string
     */
    public function getBuildStage(): string
    {
        return $this->getAttribute('build_stage');
    }

    /**
     * @return string
     */
    public function getBuildStatus(): string
    {
        return $this->getAttribute('build_status');
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getBuildStartedAt(): ?\DateTimeImmutable
    {
        return $this->getDateTimeOrNullAttribute('build_started_at');
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getBuildFinishedAt(): ?\DateTimeImmutable
    {
        return $this->getDateTimeOrNullAttribute('build_finished_at');
    }

    /**
     * @return int|null
     */
    public function getBuildDuration(): ?int
    {
        return $this->getAttribute('build_duration');
    }

    /**
     * @return bool
     */
    public function getBuildAllowFailure(): bool
    {
        return $this->getAttribute('build_allow_failure');
    }

    /**
     * @return string
     */
    public function getBuildFailureReason(): string
    {
        return $this->getAttribute('build_failure_reason');
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->getAttribute('project_id');
    }

    /**
     * @return string
     */
    public function getProjectName(): string
    {
        return $this->getAttribute('project_name');
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->getAttribute('id', 'user');
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->getAttribute('name', 'user');
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->getAttribute('email', 'user');
    }

    /**
     * @return int
     */
    public function getCommitId(): int
    {
        return $this->getAttribute('id', 'commit');
    }

    /**
     * @return string
     */
    public function getCommitSha(): string
    {
        return $this->getAttribute('sha', 'commit');
    }

    /**
     * @return string
     */
    public function getCommitMessage(): string
    {
        return $this->getAttribute('message', 'commit');
    }

    /**
     * @return string
     */
    public function getCommitAuthorName(): string
    {
        return $this->getAttribute('author_name', 'commit');
    }

    /**
     * @return string
     */
    public function getCommitAuthorEmail(): string
    {
        return $this->getAttribute('author_email', 'commit');
    }

    /**
     * @return string
     */
    public function getCommitStatus(): string
    {
        return $this->getAttribute('status', 'commit');
    }

    /**
     * @return int|null
     */
    public function getCommitDuration(): ?int
    {
        return $this->getAttribute('duration', 'commit');
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getCommitStartedAt(): ?\DateTimeImmutable
    {
        return $this->getDateTimeOrNullAttribute('started_at', 'commit');
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getCommitFinishedAt(): ?\DateTimeImmutable
    {
        return $this->getDateTimeOrNullAttribute('finished_at', 'commit');
    }

    /**
     * @return Repository
     */
    public function getRepository(): Repository
    {
        return $this->repository;
    }
}
