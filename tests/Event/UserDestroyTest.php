<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Event\UserDestroy;

class UserDestroyTest extends TestCase {

    /**
     * @return mixed[]
     */
    private function getData($filename = 'user_destroy'): array {
        $data = file_get_contents(__DIR__ . '/../fixtures/'.$filename.'.json');
        return json_decode($data, true);
    }

    public function testGetters() {
        $event = new UserDestroy($this->getData());

        $createdAt = $event->getCreatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $createdAt);
        $this->assertSame('2012-07-21 07:44:07', $createdAt->format('Y-m-d H:i:s'));

        $updatedAt = $event->getUpdatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $updatedAt);
        $this->assertSame('2012-07-21 07:38:22', $updatedAt->format('Y-m-d H:i:s'));

        $this->assertSame('js@gitlabhq.com', $event->getEmail());
        $this->assertSame('John Smith', $event->getName());
        $this->assertSame('js', $event->getUsername());
        $this->assertSame(41, $event->getUserId());
    }

}
