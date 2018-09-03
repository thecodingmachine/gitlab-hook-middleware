<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Base\Project;
use TheCodingMachine\GitlabHook\Model\Base\Repository;
use TheCodingMachine\GitlabHook\Model\Event\TagPush;

class TagPushTest extends TestCase {

    /**
     * @return mixed[]
     */
    private function getData($filename = 'tagpush'): array {
        $data = file_get_contents(__DIR__ . '/../fixtures/'.$filename.'.json');
        return json_decode($data, true);
    }

    public function testGetters() {
        $event = new TagPush($this->getData());

        $this->assertSame('0000000000000000000000000000000000000000', $event->getBefore());
        $this->assertSame('82b3d5ae55f7080f1e6022629cdb57bfae7cccc7', $event->getAfter());
        $this->assertSame('refs/tags/v1.0.0', $event->getRef());
        $this->assertSame('82b3d5ae55f7080f1e6022629cdb57bfae7cccc7', $event->getCheckoutSha());
        $this->assertSame(1, $event->getUserId());
        $this->assertSame('John Smith', $event->getUserName());
        $this->assertSame('https://s.gravatar.com/avatar/d4c74594d841139328695756648b6bd6?s=8://s.gravatar.com/avatar/d4c74594d841139328695756648b6bd6?s=80', $event->getUserAvatar());
        $this->assertSame(1, $event->getProjectId());

        $project = $event->getProject();
        $this->assertInstanceOf(Project::class, $project);
        $this->assertSame(1, $project->getId());

        $repository = $event->getRepository();
        $this->assertInstanceOf(Repository::class, $repository);
        $this->assertSame('Example', $repository->getName());

        $commits = $event->getCommits();
        $this->assertInternalType('array', $commits);
        $this->assertCount(0, $commits);

        $this->assertSame(0, $event->getTotalCommitsCount());
    }

    public function testGettersSystem() {
        $event = new TagPush($this->getData('tagpush_system'));

        $this->assertSame('0000000000000000000000000000000000000000', $event->getBefore());
        $this->assertSame('82b3d5ae55f7080f1e6022629cdb57bfae7cccc7', $event->getAfter());
        $this->assertSame('refs/tags/v1.0.0', $event->getRef());
        $this->assertSame('5937ac0a7beb003549fc5fd26fc247adbce4a52e', $event->getCheckoutSha());
        $this->assertSame(1, $event->getUserId());
        $this->assertSame('John Smith', $event->getUserName());
        $this->assertSame('https://s.gravatar.com/avatar/d4c74594d841139328695756648b6bd6?s=8://s.gravatar.com/avatar/d4c74594d841139328695756648b6bd6?s=80', $event->getUserAvatar());
        $this->assertSame(1, $event->getProjectId());

        $project = $event->getProject();
        $this->assertInstanceOf(Project::class, $project);

        $repository = $event->getRepository();
        $this->assertInstanceOf(Repository::class, $repository);

        $commits = $event->getCommits();
        $this->assertInternalType('array', $commits);
        $this->assertCount(0, $commits);

        $this->assertSame(0, $event->getTotalCommitsCount());
    }

    public function testCommits() {
        $data = $this->getData();
        $data['commits'] = [$this->getData('commit')];
        $event = new TagPush($data);

        $commits = $event->getCommits();
        $this->assertInternalType('array', $commits);
        $this->assertCount(1, $commits);
        $this->assertSame('b6568db1bc1dcd7f8b4d5a946b0b91f9dacd7327', $commits[0]->getId());
    }
}
