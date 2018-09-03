<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Base\Commit;
use TheCodingMachine\GitlabHook\Model\Base\Project;
use TheCodingMachine\GitlabHook\Model\Base\User;
use TheCodingMachine\GitlabHook\Model\Event\Pipeline;

class PipelineTest extends TestCase {

    /**
     * @return mixed[]
     */
    private function getData($filename = 'pipeline'): array {
        $data = file_get_contents(__DIR__ . '/../fixtures/'.$filename.'.json');
        return json_decode($data, true);
    }

    public function testGetters() {
        $event = new Pipeline($this->getData());

        $this->assertSame(31, $event->getId());
        $this->assertSame('master', $event->getRef());
        $this->assertSame(false, $event->getTag());
        $this->assertSame('bcbb5ec396a2c0f828686f14fac9b80b780504f2', $event->getSha());
        $this->assertSame('bcbb5ec396a2c0f828686f14fac9b80b780504f2', $event->getBeforeSha());
        $this->assertSame('success', $event->getStatus());

        $stages = $event->getStages();
        $this->assertInternalType('array', $stages);
        $this->assertCount(3, $stages);
        $this->assertSame('build', $stages[0]);
        $this->assertSame('test', $stages[1]);
        $this->assertSame('deploy', $stages[2]);

        $createdAt = $event->getCreatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $createdAt);
        $this->assertSame('2016-08-12 15:23:28', $createdAt->format('Y-m-d H:i:s'));
        $finishedAt = $event->getFinishedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $finishedAt);
        $this->assertSame('2016-08-12 15:26:29', $finishedAt->format('Y-m-d H:i:s'));

        $this->assertSame(63, $event->getDuration());

        $user = $event->getUser();
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('Administrator', $user->getName());

        $project = $event->getProject();
        $this->assertInstanceOf(Project::class, $project);
        $this->assertSame(1, $project->getId());

        $commit = $event->getCommit();
        $this->assertInstanceOf(Commit::class, $commit);
        $this->assertSame('bcbb5ec396a2c0f828686f14fac9b80b780504f2', $commit->getId());

        $builds = $event->getBuilds();
        $this->assertInternalType('array', $builds);
        $this->assertCount(5, $builds);
        $build = $builds[0];
        $this->assertSame(380, $build->getId());
        $this->assertSame('deploy', $build->getStage());
        $this->assertSame('production', $build->getName());
        $this->assertSame('skipped', $build->getStatus());

        $createdAt = $build->getCreatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $createdAt);
        $this->assertSame('2016-08-12 15:23:28', $createdAt->format('Y-m-d H:i:s'));

        $this->assertSame(null, $build->getStartedAt());
        $this->assertSame(null, $build->getFinishedAt());

        $this->assertSame('manual', $build->getWhen());
        $this->assertSame(true, $build->getManual());
        $user = $build->getUser();
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('Administrator', $user->getName());
        $this->assertSame(null, $build->getRunner());
        $artifactsFile = $build->getArtifactsFile();
        $this->assertSame(null, $artifactsFile->getFilename());
        $this->assertSame(null, $artifactsFile->getSize());

    }

}
