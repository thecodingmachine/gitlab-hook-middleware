<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Event\GroupCreate;
use TheCodingMachine\GitlabHook\Model\Event\Unknown;

class UnknownTest extends TestCase {

    /**
     * @return mixed[]
     */
    private function getData($filename = 'unknown'): array {
        $data = file_get_contents(__DIR__ . '/../fixtures/'.$filename.'.json');
        return json_decode($data, true);
    }

    public function testGetters() {
        $event = new Unknown($this->getData());

        $payload = $event->getPayload();
        $this->assertSame('test', $payload['title']);
    }

    public function testGettersSystem() {
        $event = new Unknown($this->getData('unknown_system'));

        $payload = $event->getPayload();
        $this->assertSame('test', $payload['title']);
    }

}
