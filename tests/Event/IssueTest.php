<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Base\Change;
use TheCodingMachine\GitlabHook\Model\Base\Label;
use TheCodingMachine\GitlabHook\Model\Base\Project;
use TheCodingMachine\GitlabHook\Model\Base\Repository;
use TheCodingMachine\GitlabHook\Model\Base\User;
use TheCodingMachine\GitlabHook\Model\Event\Issue;
use TheCodingMachine\GitlabHook\Model\Event\TagPush;

class IssueTest extends TestCase {

    /**
     * @return mixed[]
     */
    private function getData($filename = 'issue'): array {
        $data = file_get_contents(__DIR__ . '/../fixtures/'.$filename.'.json');
        return json_decode($data, true);
    }

    public function testGetters() {
        $event = new Issue($this->getData());

        $this->assertSame(301, $event->getId());
        $this->assertSame('New API: create/update/delete file', $event->getTitle());
        $assigneeIds = $event->getAssigneeIds();
        $this->assertCount(1, $assigneeIds);
        $this->assertSame(51, $assigneeIds[0]);
        $this->assertSame(51, $event->getAuthorId());
        $this->assertSame(14, $event->getProjectId());


        $createdAt = $event->getCreatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $createdAt);
        $this->assertSame('2013-12-03 17:15:43', $createdAt->format('Y-m-d H:i:s'));
        $updatedAt = $event->getUpdatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $updatedAt);
        $this->assertSame('2013-12-03 17:15:43', $updatedAt->format('Y-m-d H:i:s'));

        $this->assertSame(0, $event->getPosition());
        $this->assertSame(null, $event->getBranchName());
        $this->assertSame('Create new API for manipulations with repository', $event->getDescription());
        $this->assertSame(null, $event->getMilestoneId());
        $this->assertSame('opened', $event->getState());
        $this->assertSame(23, $event->getIid());
        $this->assertSame('http://example.com/diaspora/issues/23', $event->getUrl());
        $this->assertSame('open', $event->getAction());

        $user = $event->getUser();
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('Administrator', $user->getName());
        $this->assertSame('root', $user->getUsername());
        $this->assertSame("http://www.gravatar.com/avatar/e64c7d89f26bd1972efa854d13d7dd61?s=40&d=identicon", $user->getAvatarUrl());

        $project = $event->getProject();
        $this->assertInstanceOf(Project::class, $project);
        $this->assertSame(1, $project->getId());

        $repository = $event->getRepository();
        $this->assertInstanceOf(Repository::class, $repository);
        $this->assertSame('Gitlab Test', $repository->getName());

        $assignees = $event->getAssignees();
        $this->assertInternalType('array', $assignees);
        $this->assertCount(1, $assignees);
        $assignee = $assignees[0];
        $this->assertInstanceOf(User::class, $assignee);
        $this->assertSame('User1', $assignee->getName());

        /*********** Label **********/
        $labels = $event->getLabels();
        $this->assertInternalType('array', $labels);
        $this->assertCount(1, $labels);
        $label = $labels[0];
        $this->assertInstanceOf(Label::class, $label);
        $this->assertSame(206, $label->getId());
        $this->assertSame('API', $label->getTitle());
        $this->assertSame('#ffffff', $label->getColor());
        $this->assertSame(14, $label->getProjectId());

        $createdAt = $label->getCreatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $createdAt);
        $this->assertSame('2013-12-03 17:15:43', $createdAt->format('Y-m-d H:i:s'));
        $updatedAt = $label->getUpdatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $updatedAt);
        $this->assertSame('2013-12-03 17:15:43', $updatedAt->format('Y-m-d H:i:s'));

        $this->assertSame(false, $label->getTemplate());
        $this->assertSame('API related issues', $label->getDescription());
        $this->assertSame('ProjectLabel', $label->getType());
        $this->assertSame(41, $label->getGroupId());

        /*********** Change **********/
        $changes = $event->getChanges();
        $this->assertInstanceOf(Change::class, $changes);
        $updatedById = $changes->getUpdatedById();
        $this->assertInternalType('array', $updatedById);
        $this->assertCount(2, $updatedById);
        $this->assertSame(null, $updatedById[0]);
        $this->assertSame(1, $updatedById[1]);

        $updatedAt = $changes->getUpdatedAt();
        $this->assertInternalType('array', $updatedAt);
        $this->assertCount(2, $updatedAt);
        $this->assertInstanceOf(\DateTimeImmutable::class, $updatedAt[0]);
        $this->assertSame('2017-09-15 16:50:55', $updatedAt[0]->format('Y-m-d H:i:s'));
        $this->assertInstanceOf(\DateTimeImmutable::class, $updatedAt[1]);
        $this->assertSame('2017-09-15 16:52:00', $updatedAt[1]->format('Y-m-d H:i:s'));

        $labels = $changes->getLabelsPrevious();
        $this->assertInternalType('array', $labels);
        $this->assertCount(1, $labels);
        $label = $labels[0];
        $this->assertInstanceOf(Label::class, $label);
        $this->assertSame(206, $label->getId());

        $labels = $changes->getLabelsCurrent();
        $this->assertInternalType('array', $labels);
        $this->assertCount(1, $labels);
        $label = $labels[0];
        $this->assertInstanceOf(Label::class, $label);
        $this->assertSame(205, $label->getId());


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
