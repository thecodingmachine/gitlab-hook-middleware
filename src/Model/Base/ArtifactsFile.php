<?php
namespace TheCodingMachine\GitlabHook\Model\Base;

use TheCodingMachine\GitlabHook\Model\AbstractObject;

class ArtifactsFile extends AbstractObject
{
    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->getAttribute('filename');
    }

    /**
     * @return string|null
     */
    public function getSize(): ?string
    {
        return $this->getAttribute('size');
    }
}
