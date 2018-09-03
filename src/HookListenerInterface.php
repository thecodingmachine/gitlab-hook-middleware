<?php
namespace TheCodingMachine\GitlabHook;

interface HookListenerInterface
{
    public function onEvent(EventInterface $event): void;
}
