<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Event\TeamMemberAdd;

class TeamMemberAddTest extends TestCase {

    /**
     * @return mixed[]
     */
    private function getData(string $filename = 'team_member_add'): array {
        $data = file_get_contents(__DIR__ . '/../fixtures/'.$filename.'.json');
        return json_decode($data, true);
    }

    public function fileToTest()
    {
        return [['team_member_add'], ['team_member_add2']];
    }

    /**
     * @dataProvider fileToTest
     */
    public function testGetters(string $file) {
        $event = new TeamMemberAdd($this->getData($file));

        $createdAt = $event->getCreatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $createdAt);
        $this->assertSame('2012-07-21 07:30:56', $createdAt->format('Y-m-d H:i:s'));

        $updatedAt = $event->getUpdatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $updatedAt);
        $this->assertSame('2012-07-21 07:38:22', $updatedAt->format('Y-m-d H:i:s'));

        $this->assertSame('Maintainer', $event->getProjectAccess());
        $this->assertSame(74, $event->getProjectId());
        $this->assertSame('StoreCloud', $event->getProjectName());
        $this->assertSame('storecloud', $event->getProjectPath());
        $this->assertSame('jsmith/storecloud', $event->getProjectPathWithNamespace());
        $this->assertSame('johnsmith@gmail.com', $event->getUserEmail());
        $this->assertSame('John Smith', $event->getUserName());
        $this->assertSame('johnsmith', $event->getUserUsername());
        $this->assertSame(41, $event->getUserId());
        $this->assertSame('private', $event->getProjectVisibility());
    }

    public function testException()
    {
        $event = new TeamMemberAdd([]);
        $this->expectException(GitlabHookException::class);
        $event->getProjectAccess();
    }
}
