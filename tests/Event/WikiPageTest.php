<?php

namespace TheCodingMachine\GitlabHook;

use PHPUnit\Framework\TestCase;
use TheCodingMachine\GitlabHook\Model\Base\Project;
use TheCodingMachine\GitlabHook\Model\Base\User;
use TheCodingMachine\GitlabHook\Model\Base\Wiki;
use TheCodingMachine\GitlabHook\Model\Event\WikiPage;

class WikiPageTest extends TestCase {

    /**
     * @return mixed[]
     */
    private function getData($filename = 'wiki_page'): array {
        $data = file_get_contents(__DIR__ . '/../fixtures/'.$filename.'.json');
        return json_decode($data, true);
    }

    public function testGetters() {
        $event = new WikiPage($this->getData());

        $this->assertSame('Awesome', $event->getTitle());
        $this->assertSame('awesome content goes here', $event->getContent());
        $this->assertSame('markdown', $event->getFormat());
        $this->assertSame('adding an awesome page to the wiki', $event->getMessage());
        $this->assertSame('awesome', $event->getSlug());
        $this->assertSame('http://example.com/root/awesome-project/wikis/awesome', $event->getUrl());
        $this->assertSame('create', $event->getAction());

        $user = $event->getUser();
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('Administrator', $user->getName());

        $project = $event->getProject();
        $this->assertInstanceOf(Project::class, $project);
        $this->assertSame(1, $project->getId());

        $wiki = $event->getWiki();
        $this->assertInstanceOf(Wiki::class, $wiki);
        $this->assertSame('http://example.com/root/awesome-project/wikis/home', $wiki->getWebUrl());
        $this->assertSame('git@example.com:root/awesome-project.wiki.git', $wiki->getGitSshUrl());
        $this->assertSame('http://example.com/root/awesome-project.wiki.git', $wiki->getGitHttpUrl());
        $this->assertSame('root/awesome-project.wiki', $wiki->getPathWithNamespace());
        $this->assertSame('master', $wiki->getDefaultBranch());

    }
}
