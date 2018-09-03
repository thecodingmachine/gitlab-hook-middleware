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
use TheCodingMachine\GitlabHook\Model\Base\Wiki;
use TheCodingMachine\GitlabHook\Model\Event\GroupCreate;
use TheCodingMachine\GitlabHook\Model\Event\GroupDestroy;
use TheCodingMachine\GitlabHook\Model\Event\GroupRename;
use TheCodingMachine\GitlabHook\Model\Event\Issue;
use TheCodingMachine\GitlabHook\Model\Event\KeyCreate;
use TheCodingMachine\GitlabHook\Model\Event\KeyDestroy;
use TheCodingMachine\GitlabHook\Model\Event\MergeRequest;
use TheCodingMachine\GitlabHook\Model\Event\ProjectCreate;
use TheCodingMachine\GitlabHook\Model\Event\ProjectDestroy;
use TheCodingMachine\GitlabHook\Model\Event\ProjectRename;
use TheCodingMachine\GitlabHook\Model\Event\ProjectTransfer;
use TheCodingMachine\GitlabHook\Model\Event\ProjectUpdate;
use TheCodingMachine\GitlabHook\Model\Event\Push;
use TheCodingMachine\GitlabHook\Model\Event\TagPush;
use TheCodingMachine\GitlabHook\Model\Event\TeamMemberAdd;
use TheCodingMachine\GitlabHook\Model\Event\TeamMemberRemove;
use TheCodingMachine\GitlabHook\Model\Event\Unknown;
use TheCodingMachine\GitlabHook\Model\Event\UserCreate;
use TheCodingMachine\GitlabHook\Model\Event\UserDestroy;
use TheCodingMachine\GitlabHook\Model\Event\UserFailedLogin;
use TheCodingMachine\GitlabHook\Model\Event\UserGroupAdd;
use TheCodingMachine\GitlabHook\Model\Event\UserGroupRemove;
use TheCodingMachine\GitlabHook\Model\Event\UserRename;
use TheCodingMachine\GitlabHook\Model\Event\WikiPage;

class HookReceiverTest extends TestCase {

    public function testListener() {
        $listener = new class implements HookListenerInterface {
            public $event;

            public function onEvent(EventInterface $event): void {
                $this->event = $event;
            }
        };

        $hookReceiver = new HookReceiver([$listener]);

        $data = file_get_contents(__DIR__.'/fixtures/push.json');
        $hookReceiver->handle(json_decode($data, true), 'Push Hook');
        $this->assertInstanceOf(Push::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/tagpush.json');
        $hookReceiver->handle(json_decode($data, true), 'Tag Push Hook');
        $this->assertInstanceOf(TagPush::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/issue.json');
        $hookReceiver->handle(json_decode($data, true), 'Issue Hook');
        $this->assertInstanceOf(Issue::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/merge_request.json');
        $hookReceiver->handle(json_decode($data, true), 'Merge Request Hook');
        $this->assertInstanceOf(MergeRequest::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/wiki_page.json');
        $hookReceiver->handle(json_decode($data, true), 'Wiki Page Hook');
        $this->assertInstanceOf(WikiPage::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/merge_request.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(MergeRequest::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/project_create.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(ProjectCreate::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/project_destroy.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(ProjectDestroy::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/project_rename.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(ProjectRename::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/project_transfer.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(ProjectTransfer::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/project_update.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(ProjectUpdate::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/team_member_add.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(TeamMemberAdd::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/team_member_remove.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(TeamMemberRemove::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/user_create.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(UserCreate::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/user_destroy.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(UserDestroy::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/user_failed.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(UserFailedLogin::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/user_rename.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(UserRename::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/key_create.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(KeyCreate::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/key_destroy.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(KeyDestroy::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/group_create.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(GroupCreate::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/group_destroy.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(GroupDestroy::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/group_rename.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(GroupRename::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/user_group_add.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(UserGroupAdd::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/user_group_remove.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(UserGroupRemove::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/tagpush_system.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(TagPush::class, $listener->event);

        $data = file_get_contents(__DIR__.'/fixtures/push_system.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(Push::class, $listener->event);


        $data = file_get_contents(__DIR__.'/fixtures/unknown.json');
        $hookReceiver->handle(json_decode($data, true), 'Unknown Hook');
        $this->assertInstanceOf(Unknown::class, $listener->event);


        $data = file_get_contents(__DIR__.'/fixtures/unknown_system.json');
        $hookReceiver->handle(json_decode($data, true), 'System Hook');
        $this->assertInstanceOf(Unknown::class, $listener->event);
    }
}
