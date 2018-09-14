<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Event\GroupRename;

class GroupRenameTest extends TestCase {

    /**
     * @return mixed[]
     */
    private function getData($filename = 'group_rename'): array {
        $data = file_get_contents(__DIR__ . '/../fixtures/'.$filename.'.json');
        return json_decode($data, true);
    }

    public function testGetters() {
        $event = new GroupRename($this->getData());

        $createdAt = $event->getCreatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $createdAt);
        $this->assertSame('2017-10-30 15:09:00', $createdAt->format('Y-m-d H:i:s'));

        $updatedAt = $event->getUpdatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $updatedAt);
        $this->assertSame('2017-11-01 10:23:52', $updatedAt->format('Y-m-d H:i:s'));

        $this->assertSame('Better Name', $event->getName());
        $this->assertSame('old-name', $event->getOldPath());
        $this->assertSame('better-name', $event->getPath());
        $this->assertSame('parent-group/better-name', $event->getFullPath());
        $this->assertSame('parent-group/old-name', $event->getOldFullPath());
        $this->assertSame(null, $event->getOwnerEmail());
        $this->assertSame(null, $event->getOwnerName());
        $this->assertSame('better-name', $event->getPath());
        $this->assertSame(64, $event->getGroupId());
    }

}
