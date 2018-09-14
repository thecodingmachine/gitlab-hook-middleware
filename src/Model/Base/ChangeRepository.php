<?php
namespace TheCodingMachine\GitlabHook\Model\Base;

use TheCodingMachine\GitlabHook\Model\AbstractObject;

class ChangeRepository extends AbstractObject
{

    /**
     * @var Label[]
     */
    private $labelsPrevious = [];

    /**
     * @var Label[]
     */
    private $labelsCurrent = [];

    /**
     * Repository constructor.
     *
     * @param mixed[] $payload
     */
    public function __construct(array $payload)
    {
        parent::__construct($payload);
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
}
