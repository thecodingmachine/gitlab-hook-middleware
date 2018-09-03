<?php
namespace TheCodingMachine\GitlabHook\Model\Base;

use TheCodingMachine\GitlabHook\Model\AbstractObject;

class Author extends AbstractObject
{

    /**
     * Author constructor.
     *
     * @param array $payload
     */
    public function __construct(array $payload)
    {
        parent::__construct($payload);
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
    public function getEmail(): string
    {
        return $this->getAttribute('email');
    }
}
