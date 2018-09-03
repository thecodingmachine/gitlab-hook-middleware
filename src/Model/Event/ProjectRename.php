<?php
namespace TheCodingMachine\GitlabHook\Model\Event;

class ProjectRename extends AbstractProject
{
    /**
     * @return string
     */
    public function getOldPathWithNamespace(): string
    {
        return $this->getAttribute('old_path_with_namespace');
    }
}
