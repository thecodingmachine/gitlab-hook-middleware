<?php
namespace TheCodingMachine\GitlabHook\Model\Base;

use TheCodingMachine\GitlabHook\Model\AbstractObject;

class Build extends AbstractObject
{

    /**
     * @var User
     */
    private $user;

    /**
     * @var ArtifactsFile
     */
    private $artifactsFile;
    /**
     * Wiki constructor.
     *
     * @param array $payload
     */
    public function __construct(array $payload)
    {
        parent::__construct($payload);
        $this->user = new User($this->getAttribute('user'));
        $this->artifactsFile = new ArtifactsFile($this->getAttribute('artifacts_file'));
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    /**
     * @return string
     */
    public function getStage(): string
    {
        return $this->getAttribute('stage');
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
    public function getStatus(): string
    {
        return $this->getAttribute('status');
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->getDateTimeAttribute('created_at');
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->getDateTimeOrNullAttribute('started_at');
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getFinishedAt(): ?\DateTimeImmutable
    {
        return $this->getDateTimeOrNullAttribute('finished_at');
    }

    /**
     * @return string
     */
    public function getWhen(): string
    {
        return $this->getAttribute('when');
    }

    /**
     * @return bool
     */
    public function getManual(): bool
    {
        return $this->getAttribute('manual');
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string|null
     */
    public function getRunner(): ?string
    {
        return $this->getAttribute('runner');
    }

    /**
     * @return ArtifactsFile
     */
    public function getArtifactsFile(): ArtifactsFile
    {
        return $this->artifactsFile;
    }
}
