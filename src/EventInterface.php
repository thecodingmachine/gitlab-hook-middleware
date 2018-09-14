<?php
namespace TheCodingMachine\GitlabHook;

interface EventInterface
{
    /**
     * @return mixed[]
     */
    public function getPayload(): array;
}
