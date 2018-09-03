<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Event\UserFailedLogin;

class UserFailedLoginTest extends TestCase {

    /**
     * @return mixed[]
     */
    private function getData($filename = 'user_failed'): array {
        $data = file_get_contents(__DIR__ . '/../fixtures/'.$filename.'.json');
        return json_decode($data, true);
    }

    public function testGetters() {
        $event = new UserFailedLogin($this->getData());

        $createdAt = $event->getCreatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $createdAt);
        $this->assertSame('2017-10-03 06:08:48', $createdAt->format('Y-m-d H:i:s'));

        $updatedAt = $event->getUpdatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $updatedAt);
        $this->assertSame('2018-01-15 04:52:06', $updatedAt->format('Y-m-d H:i:s'));

        $this->assertSame('user4@example.com', $event->getEmail());
        $this->assertSame('John Smith', $event->getName());
        $this->assertSame('user4', $event->getUsername());
        $this->assertSame(26, $event->getUserId());
        $this->assertSame('blocked', $event->getState());
    }

}
