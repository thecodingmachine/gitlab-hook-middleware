<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Base\ChangeRepository;
use TheCodingMachine\GitlabHook\Model\Base\Project;
use TheCodingMachine\GitlabHook\Model\Event\RepositoryUpdate;

class RepositoryUpdateTest extends TestCase {

    /**
     * @return mixed[]
     */
    private function getData($filename = 'repository_update'): array {
        $data = file_get_contents(__DIR__ . '/../fixtures/'.$filename.'.json');
        return json_decode($data, true);
    }

    public function testGetters() {
        $event = new RepositoryUpdate($this->getData());

        $this->assertSame(1, $event->getUserId());
        $this->assertSame('John Smith', $event->getUserName());
        $this->assertSame('admin@example.com', $event->getUserEmail());
        $this->assertSame('https://s.gravatar.com/avatar/d4c74594d841139328695756648b6bd6?s=8://s.gravatar.com/avatar/d4c74594d841139328695756648b6bd6?s=80', $event->getUserAvatar());
        $this->assertSame(1, $event->getProjectId());

        $project = $event->getProject();
        $this->assertInstanceOf(Project::class, $project);
        $this->assertSame('Example', $project->getName());

        $changes = $event->getChanges();
        $this->assertInternalType('array', $changes);
        $this->assertCount(1, $changes);
        $change = $changes[0];
        $this->assertInstanceOf(ChangeRepository::class, $change);
        $this->assertSame('8205ea8d81ce0c6b90fbe8280d118cc9fdad6130', $change->getBefore());
        $this->assertSame('4045ea7a3df38697b3730a20fb73c8bed8a3e69e', $change->getAfter());
        $this->assertSame('refs/heads/master', $change->getRef());

        $refs = $event->getRefs();
        $this->assertInternalType('array', $refs);
        $this->assertCount(1, $refs);
        $ref = $refs[0];
        $this->assertSame('refs/heads/master', $ref);
    }

}
