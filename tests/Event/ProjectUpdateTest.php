<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Event\ProjectUpdate;

class ProjectUpdateTest extends TestCase {

    /**
     * @return mixed[]
     */
    private function getData($filename = 'project_update'): array {
        $data = file_get_contents(__DIR__ . '/../fixtures/'.$filename.'.json');
        return json_decode($data, true);
    }

    public function testGetters() {
        $event = new ProjectUpdate($this->getData());

        $createdAt = $event->getCreatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $createdAt);
        $this->assertSame('2012-07-21 07:30:54', $createdAt->format('Y-m-d H:i:s'));

        $updatedAt = $event->getUpdatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $updatedAt);
        $this->assertSame('2012-07-21 07:38:22', $updatedAt->format('Y-m-d H:i:s'));

        $this->assertSame('StoreCloud', $event->getName());
        $this->assertSame('johnsmith@gmail.com', $event->getOwnerEmail());
        $this->assertSame('John Smith', $event->getOwnerName());
        $this->assertSame('storecloud', $event->getPath());
        $this->assertSame('jsmith/storecloud', $event->getPathWithNamespace());
        $this->assertSame(74, $event->getProjectId());
        $this->assertSame('private', $event->getProjectVisibility());
    }

}
