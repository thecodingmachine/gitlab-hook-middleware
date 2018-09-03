<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Event\TeamMemberRemove;
use TheCodingMachine\GitlabHook\Model\Event\UserCreate;
use TheCodingMachine\GitlabHook\Model\Event\UserDestroy;
use TheCodingMachine\GitlabHook\Model\Event\UserFailedLogin;
use TheCodingMachine\GitlabHook\Model\Event\UserRename;

class UserRenameTest extends TestCase {

    /**
     * @return mixed[]
     */
    private function getData($filename = 'user_rename'): array {
        $data = file_get_contents(__DIR__ . '/../fixtures/'.$filename.'.json');
        return json_decode($data, true);
    }

    public function testGetters() {
        $event = new UserRename($this->getData());

        $createdAt = $event->getCreatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $createdAt);
        $this->assertSame('2017-11-01 11:21:04', $createdAt->format('Y-m-d H:i:s'));

        $updatedAt = $event->getUpdatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $updatedAt);
        $this->assertSame('2017-11-01 14:04:47', $updatedAt->format('Y-m-d H:i:s'));

        $this->assertSame('best-email@example.tld', $event->getEmail());
        $this->assertSame('new-name', $event->getName());
        $this->assertSame('new-exciting-name', $event->getUsername());
        $this->assertSame(58, $event->getUserId());
        $this->assertSame('old-boring-name', $event->getOldUsername());
    }

}
