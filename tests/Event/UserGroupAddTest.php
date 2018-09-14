<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Event\UserGroupAdd;

class UserGroupAddTest extends TestCase {

    /**
     * @return mixed[]
     */
    private function getData($filename = 'user_group_add'): array {
        $data = file_get_contents(__DIR__ . '/../fixtures/'.$filename.'.json');
        return json_decode($data, true);
    }

    public function testGetters() {
        $event = new UserGroupAdd($this->getData());

        $createdAt = $event->getCreatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $createdAt);
        $this->assertSame('2012-07-21 07:30:56', $createdAt->format('Y-m-d H:i:s'));

        $updatedAt = $event->getUpdatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $updatedAt);
        $this->assertSame('2012-07-21 07:38:22', $updatedAt->format('Y-m-d H:i:s'));

        $this->assertSame('Maintainer', $event->getGroupAccess());
        $this->assertSame(78, $event->getGroupId());
        $this->assertSame('StoreCloud', $event->getGroupName());
        $this->assertSame('storecloud', $event->getGroupPath());

        $this->assertSame('johnsmith@gmail.com', $event->getUserEmail());
        $this->assertSame('John Smith', $event->getUserName());
        $this->assertSame('johnsmith', $event->getUserUsername());
        $this->assertSame(41, $event->getUserId());
    }

}
