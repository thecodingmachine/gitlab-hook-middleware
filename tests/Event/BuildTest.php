<?php

namespace TheCodingMachine\GitlabHook\Event;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\GitlabHookException;
use TheCodingMachine\GitlabHook\Model\Base\Repository;
use TheCodingMachine\GitlabHook\Model\Event\Build;

class BuildTest extends TestCase
{

    /**
     * @return mixed[]
     */
    private function getData(): array {
        $data = file_get_contents(__DIR__.'/../fixtures/build.json');
        return json_decode($data, true);
    }

    public function testGetters() {
        $event = new Build($this->getData());

        $this->assertSame('gitlab-script-trigger', $event->getRef());
        $this->assertSame(false, $event->getTag());
        $this->assertSame('2293ada6b400935a1378653304eaf6221e0fdb8f', $event->getBeforeSha());
        $this->assertSame('2293ada6b400935a1378653304eaf6221e0fdb8f', $event->getSha());
        $this->assertSame(1977, $event->getBuildId());
        $this->assertSame('test', $event->getBuildName());
        $this->assertSame('test', $event->getBuildStage());
        $this->assertSame('created', $event->getBuildStatus());
        $this->assertSame(null, $event->getBuildStartedAt());
        $this->assertSame(null, $event->getBuildFinishedAt());
        $this->assertSame(null, $event->getBuildDuration());
        $this->assertSame(false, $event->getBuildAllowFailure());
        $this->assertSame('script_failure', $event->getBuildFailureReason());
        $this->assertSame(380, $event->getProjectId());
        $this->assertSame('gitlab-org/gitlab-test', $event->getProjectName());

        $this->assertSame(3, $event->getUserId());
        $this->assertSame('User', $event->getUserName());
        $this->assertSame('user@gitlab.com', $event->getUserEmail());


        $this->assertSame(2366, $event->getCommitId());
        $this->assertSame('2293ada6b400935a1378653304eaf6221e0fdb8f', $event->getCommitSha());
        $this->assertSame("test\n", $event->getCommitMessage());
        $this->assertSame('User', $event->getCommitAuthorName());
        $this->assertSame('user@gitlab.com', $event->getCommitAuthorEmail());
        $this->assertSame('created', $event->getCommitStatus());
        $this->assertSame(null, $event->getCommitDuration());
        $this->assertSame(null, $event->getCommitStartedAt());
        $this->assertSame(null, $event->getCommitFinishedAt());

        $repository = $event->getRepository();
        $this->assertInstanceOf(Repository::class, $repository);
        $this->assertSame('gitlab_test', $repository->getName());
        $this->assertSame('Atque in sunt eos similique dolores voluptatem.', $repository->getDescription());
        $this->assertSame('http://192.168.64.1:3005/gitlab-org/gitlab-test', $repository->getHomepage());
        $this->assertSame('git@192.168.64.1:gitlab-org/gitlab-test.git', $repository->getGitSshUrl());
        $this->assertSame('http://192.168.64.1:3005/gitlab-org/gitlab-test.git', $repository->getGitHttpUrl());
        $this->assertSame(20, $repository->getVisibilityLevel());

    }

    public function testDateTime() {
        $data = $this->getData();

        $data['commit']['started_at'] = '2012-01-03T23:36:29+02:00';
        $data['commit']['finished_at'] = '2012-01-03T23:38:29+02:00';
        $event = new Build($data);
        $startedAt = $event->getCommitStartedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $startedAt);
        $this->assertSame('2012-01-03 23:36:29', $startedAt->format('Y-m-d H:i:s'));
        $finishedAt = $event->getCommitFinishedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $finishedAt);
        $this->assertSame('2012-01-03 23:38:29', $finishedAt->format('Y-m-d H:i:s'));
    }

    public function testExceptionUserId() {
        $data = $this->getData();
        unset($data['user']['id']);
        $event = new Build($data);
        $this->expectException(GitlabHookException::class);
        $event->getUserId();
    }

    public function testExceptionCommitId() {
        $data = $this->getData();
        unset($data['commit']['id']);
        $event = new Build($data);
        $this->expectException(GitlabHookException::class);
        $event->getCommitId();
    }
}
