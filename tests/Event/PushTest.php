<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Base\Author;
use TheCodingMachine\GitlabHook\Model\Base\Commit;
use TheCodingMachine\GitlabHook\Model\Base\Project;
use TheCodingMachine\GitlabHook\Model\Base\Repository;
use TheCodingMachine\GitlabHook\Model\Event\Push;

class PushTest extends TestCase
{

    public function testGetters() {
        $data = file_get_contents(__DIR__.'/../fixtures/push.json');
        $event = new Push(json_decode($data, true));

        $this->assertSame('95790bf891e76fee5e1747ab589903a6a1f80f22', $event->getBefore());
        $this->assertSame('da1560886d4f094c3e6c9ef40349f7d38b5d27d7', $event->getAfter());
        $this->assertSame('refs/heads/master', $event->getRef());
        $this->assertSame('da1560886d4f094c3e6c9ef40349f7d38b5d27d7', $event->getCheckoutSha());
        $this->assertSame(4, $event->getUserId());
        $this->assertSame('John Smith', $event->getUserName());
        $this->assertSame('jsmith', $event->getUserUserName());
        $this->assertSame('john@example.com', $event->getUserEmail());
        $this->assertSame('https://s.gravatar.com/avatar/d4c74594d841139328695756648b6bd6?s=8://s.gravatar.com/avatar/d4c74594d841139328695756648b6bd6?s=80', $event->getUserAvatar());
        $this->assertSame(15, $event->getProjectId());

        $project = $event->getProject();
        $this->assertInstanceOf(Project::class, $project);
        $this->assertSame(15, $project->getId());
        $this->assertSame('Diaspora', $project->getName());
        $this->assertSame('', $project->getDescription());
        $this->assertSame('http://example.com/mike/diaspora', $project->getWebUrl());
        $this->assertSame(null, $project->getAvatarUrl());
        $this->assertSame('git@example.com:mike/diaspora.git', $project->getGitSshUrl());
        $this->assertSame('http://example.com/mike/diaspora.git', $project->getGitHttpUrl());
        $this->assertSame('Mike', $project->getNamespace());
        $this->assertSame(0, $project->getVisibilityLevel());
        $this->assertSame('mike/diaspora', $project->getPathWithNamespace());
        $this->assertSame('master', $project->getDefaultBranch());
        $this->assertSame('http://example.com/mike/diaspora', $project->getHomepage());
        $this->assertSame('git@example.com:mike/diaspora.git', $project->getUrl());
        $this->assertSame('git@example.com:mike/diaspora.git', $project->getSshUrl());
        $this->assertSame('http://example.com/mike/diaspora.git', $project->getHttpUrl());

        $repository = $event->getRepository();
        $this->assertInstanceOf(Repository::class, $repository);
        $this->assertSame('Diaspora', $repository->getName());
        $this->assertSame('git@example.com:mike/diaspora.git', $repository->getUrl());
        $this->assertSame('', $repository->getDescription());
        $this->assertSame('http://example.com/mike/diaspora', $repository->getHomepage());
        $this->assertSame('git@example.com:mike/diaspora.git', $repository->getGitSshUrl());
        $this->assertSame('http://example.com/mike/diaspora.git', $repository->getGitHttpUrl());
        $this->assertSame(0, $repository->getVisibilityLevel());

        $commits = $event->getCommits();
        $this->assertInternalType('array', $commits);
        $this->assertCount(2, $commits);
        $commit = $commits[0];
        $this->assertInstanceOf(Commit::class, $commit);
        $this->assertSame('b6568db1bc1dcd7f8b4d5a946b0b91f9dacd7327', $commit->getId());
        $this->assertSame('Update Catalan translation to e38cb41.', $commit->getMessage());

        $timestamp = $commit->getTimestamp();
        $this->assertInstanceOf(\DateTimeImmutable::class, $timestamp);
        $this->assertSame('2011-12-12 14:27:31', $timestamp->format('Y-m-d H:i:s'));

        $this->assertSame('http://example.com/mike/diaspora/commit/b6568db1bc1dcd7f8b4d5a946b0b91f9dacd7327', $commit->getUrl());
        $author = $commit->getAuthor();
        $this->assertInstanceOf(Author::class, $author);
        $this->assertSame('Jordi Mallach', $author->getName());
        $this->assertSame('jordi@softcatala.org', $author->getEmail());

        $added = $commit->getAdded();
        $this->assertInternalType('array', $added);
        $this->assertCount(1, $added);
        $this->assertSame('CHANGELOG', $added[0]);

        $modified = $commit->getModified();
        $this->assertInternalType('array', $modified);
        $this->assertCount(1, $modified);
        $this->assertSame('app/controller/application.rb', $modified[0]);

        $removed = $commit->getRemoved();
        $this->assertInternalType('array', $removed);
        $this->assertCount(0, $removed);

        $this->assertSame(4, $event->getTotalCommitsCount());
    }
}
