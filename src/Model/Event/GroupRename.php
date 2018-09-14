<?php
namespace TheCodingMachine\GitlabHook\Model\Event;

class GroupRename extends AbstractGroup
{
    /**
     * @return string
     */
    public function getFullPath(): string
    {
        return $this->getAttribute('full_path');
    }

    /**
     * @return string
     */
    public function getOldPath(): string
    {
        return $this->getAttribute('old_path');
    }

    /**
     * @return string
     */
    public function getOldFullPath(): string
    {
        return $this->getAttribute('old_full_path');
    }
}
