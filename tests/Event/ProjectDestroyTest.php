<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Event\ProjectDestroy;

class ProjectDestroyTest extends TestCase {

    /**
     * @return mixed[]
     */
    private function getData($filename = 'project_destroy'): array {
        $data = file_get_contents(__DIR__ . '/../fixtures/'.$filename.'.json');
        return json_decode($data, true);
    }

    public function testGetters() {
        $event = new ProjectDestroy($this->getData());

        $createdAt = $event->getCreatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $createdAt);
        $this->assertSame('2012-07-21 07:30:58', $createdAt->format('Y-m-d H:i:s'));

        $updatedAt = $event->getUpdatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $updatedAt);
        $this->assertSame('2012-07-21 07:38:22', $updatedAt->format('Y-m-d H:i:s'));

        $this->assertSame('Underscore', $event->getName());
        $this->assertSame('johnsmith@gmail.com', $event->getOwnerEmail());
        $this->assertSame('John Smith', $event->getOwnerName());
        $this->assertSame('underscore', $event->getPath());
        $this->assertSame('jsmith/underscore', $event->getPathWithNamespace());
        $this->assertSame(73, $event->getProjectId());
        $this->assertSame('internal', $event->getProjectVisibility());
    }

}
