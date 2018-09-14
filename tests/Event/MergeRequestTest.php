<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Base\Branch;
use TheCodingMachine\GitlabHook\Model\Base\Change;
use TheCodingMachine\GitlabHook\Model\Base\Commit;
use TheCodingMachine\GitlabHook\Model\Base\Label;
use TheCodingMachine\GitlabHook\Model\Base\Project;
use TheCodingMachine\GitlabHook\Model\Base\Repository;
use TheCodingMachine\GitlabHook\Model\Base\User;
use TheCodingMachine\GitlabHook\Model\Event\MergeRequest;

class MergeRequestTest extends TestCase {

    /**
     * @return mixed[]
     */
    private function getData($filename = 'merge_request'): array {
        $data = file_get_contents(__DIR__ . '/../fixtures/'.$filename.'.json');
        return json_decode($data, true);
    }

    public function testGetters() {
        $event = new MergeRequest($this->getData());

        $this->assertSame(99, $event->getId());
        $this->assertSame('master', $event->getTargetBranch());
        $this->assertSame('ms-viewport', $event->getSourceBranch());
        $this->assertSame(14, $event->getSourceProjectId());
        $this->assertSame(51, $event->getAuthorId());
        $this->assertSame(6, $event->getAssigneeId());
        $this->assertSame('MS-Viewport', $event->getTitle());

        $createdAt = $event->getCreatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $createdAt);
        $this->assertSame('2013-12-03 17:23:34', $createdAt->format('Y-m-d H:i:s'));
        $updatedAt = $event->getUpdatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $updatedAt);
        $this->assertSame('2013-12-03 17:23:34', $updatedAt->format('Y-m-d H:i:s'));
        $this->assertSame(null, $event->getMilestoneId());
        $this->assertSame('opened', $event->getState());
        $this->assertSame('unchecked', $event->getMergeState());
        $this->assertSame(14, $event->getTargetProjectId());
        $this->assertSame(1, $event->getIid());
        $this->assertSame('', $event->getDescription());

        $source = $event->getSource();
        $this->assertInstanceOf(Branch::class, $source);
        $this->assertSame('Awesome Project', $source->getName());
        $this->assertSame('Aut reprehenderit ut est.', $source->getDescription());
        $this->assertSame('http://example.com/awesome_space/awesome_project', $source->getWebUrl());
        $this->assertSame(null, $source->getAvatarUrl());
        $this->assertSame('git@example.com:awesome_space/awesome_project.git', $source->getGitSshUrl());
        $this->assertSame('http://example.com/awesome_space/awesome_project.git', $source->getGitHttpUrl());
        $this->assertSame('Awesome Space', $source->getNamespace());
        $this->assertSame(20, $source->getVisibilityLevel());
        $this->assertSame('awesome_space/awesome_project', $source->getPathWithNamespace());
        $this->assertSame('master', $source->getDefaultBranch());
        $this->assertSame('http://example.com/awesome_space/awesome_project', $source->getHomepage());
        $this->assertSame('http://example.com/awesome_space/awesome_project.git', $source->getUrl());
        $this->assertSame('git@example.com:awesome_space/awesome_project.git', $source->getSshUrl());
        $this->assertSame('http://example.com/awesome_space/awesome_project.git', $source->getHttpUrl());

        $target = $event->getTarget();
        $this->assertInstanceOf(Branch::class, $target);
        $this->assertSame('Awesome Project', $target->getName());

        $lastCommit = $event->getLastCommit();
        $this->assertInstanceOf(Commit::class, $lastCommit);
        $this->assertSame('da1560886d4f094c3e6c9ef40349f7d38b5d27d7', $lastCommit->getId());

        $this->assertSame(false, $event->getWorkInProgress());
        $this->assertSame('http://example.com/diaspora/merge_requests/1', $event->getUrl());
        $this->assertSame('open', $event->getAction());

        $assignee = $event->getAssignee();
        $this->assertInstanceOf(User::class, $assignee);
        $this->assertSame('User1', $assignee->getName());

        $labels = $event->getLabels();
        $this->assertInternalType('array', $labels);
        $this->assertCount(1, $labels);
        $label = $labels[0];
        $this->assertInstanceOf(Label::class, $label);
        $this->assertSame(206, $label->getId());

        $changes = $event->getChanges();
        $this->assertInstanceOf(Change::class, $changes);
        $updatedById = $changes->getUpdatedById();
        $this->assertInternalType('array', $updatedById);
        $this->assertCount(2, $updatedById);
        $this->assertSame(null, $updatedById[0]);
        $this->assertSame(1, $updatedById[1]);

        $user = $event->getUser();
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('Administrator', $user->getName());

        $project = $event->getProject();
        $this->assertInstanceOf(Project::class, $project);
        $this->assertSame(1, $project->getId());

        $repository = $event->getRepository();
        $this->assertInstanceOf(Repository::class, $repository);
        $this->assertSame('Gitlab Test', $repository->getName());
    }

}
