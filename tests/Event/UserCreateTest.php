<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Event\UserCreate;

class UserCreateTest extends TestCase {

    /**
     * @return mixed[]
     */
    private function getData($filename = 'user_create'): array {
        $data = file_get_contents(__DIR__ . '/../fixtures/'.$filename.'.json');
        return json_decode($data, true);
    }

    public function testGetters() {
        $event = new UserCreate($this->getData());

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


    public function testPayload() {
        $event = new UserCreate($this->getData());
        $payload = $event->getPayload();

        $this->assertInternalType('array', $payload);
        $this->assertCount(7, $payload);

        $this->assertSame('2012-07-21T07:44:07Z', $payload['created_at']);
        $this->assertSame('2012-07-21T07:38:22Z', $payload['updated_at']);
        $this->assertSame('js@gitlabhq.com', $payload['email']);
        $this->assertSame('John Smith', $payload['name']);
        $this->assertSame('js', $payload['username']);
        $this->assertSame(41, $payload['user_id']);
    }

}
