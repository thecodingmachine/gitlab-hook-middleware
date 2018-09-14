<?php
namespace TheCodingMachine\GitlabHook\Model\Base;

use TheCodingMachine\GitlabHook\Model\AbstractObject;

class Commit extends AbstractObject
{

    /**
     * @var Author
     */
    private $author;

    /**
     * Commit constructor.
     *
     * @param mixed[] $payload
     */
    public function __construct(array $payload)
    {
        parent::__construct($payload);
        $this->author = new Author($this->getAttribute('author'));
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getAttribute('id');
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->getAttribute('message');
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getTimestamp(): \DateTimeImmutable
    {
        return $this->getDateTimeAttribute('timestamp');
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->getAttribute('url');
    }

    /**
     * @return Author
     */
    public function getAuthor(): Author
    {
        return $this->author;
    }

    /**
     * @return string[]
     */
    public function getAdded(): array
    {
        return $this->getAttribute('added');
    }

    /**
     * @return string[]
     */
    public function getModified(): array
    {
        return $this->getAttribute('modified');
    }

    /**
     * @return string[]
     */
    public function getRemoved(): array
    {
        return $this->getAttribute('removed');
    }
}
