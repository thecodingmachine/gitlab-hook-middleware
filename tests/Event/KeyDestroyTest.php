<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Event\KeyDestroy;

class KeyDestroyTest extends TestCase {

    /**
     * @return mixed[]
     */
    private function getData($filename = 'key_destroy'): array {
        $data = file_get_contents(__DIR__ . '/../fixtures/'.$filename.'.json');
        return json_decode($data, true);
    }

    public function testGetters() {
        $event = new KeyDestroy($this->getData());

        $createdAt = $event->getCreatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $createdAt);
        $this->assertSame('2014-08-18 18:45:16', $createdAt->format('Y-m-d H:i:s'));

        $updatedAt = $event->getUpdatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $updatedAt);
        $this->assertSame('2012-07-21 07:38:22', $updatedAt->format('Y-m-d H:i:s'));

        $this->assertSame('root', $event->getUsername());
        $this->assertSame("ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC58FwqHUbebw2SdT7SP4FxZ0w+lAO/erhy2ylhlcW/tZ3GY3mBu9VeeiSGoGz8hCx80Zrz+aQv28xfFfKlC8XQFpCWwsnWnQqO2Lv9bS8V1fIHgMxOHIt5Vs+9CAWGCCvUOAurjsUDoE2ALIXLDMKnJxcxD13XjWdK54j6ZXDB4syLF0C2PnAQSVY9X7MfCYwtuFmhQhKaBussAXpaVMRHltie3UYSBUUuZaB3J4cg/7TxlmxcNd+ppPRIpSZAB0NI6aOnqoBCpimscO/VpQRJMVLr3XiSYeT6HBiDXWHnIVPfQc03OGcaFqOit6p8lYKMaP/iUQLm+pgpZqrXZ9vB john@localhost", $event->getKey());
        $this->assertSame(4, $event->getId());
    }

}
