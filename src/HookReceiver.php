<?php


namespace TheCodingMachine\GitlabHook;

use Psr\Http\Message\RequestInterface;
use TheCodingMachine\GitlabHook\Model\Event;

class HookReceiver
{

    /**
     * @var HookListenerInterface[]
     */
    private $listeners = [];

    /**
     * HookReceiver constructor.
     *
     * @param HookListenerInterface[] $listeners
     */
    public function __construct(array $listeners)
    {
        $this->listeners = $listeners;
    }

    /**
     * @param mixed[] $payload
     * @param string $type The type of the event, typically received in the X-Gitlab-Event HTTP header
     */
    public function handle(array $payload, string $type): void
    {
        switch ($type) {
            case 'Push Hook':
                $event = new Event\Push($payload);
                break;
            case 'Tag Push Hook':
                $event = new Event\TagPush($payload);
                break;
            case 'Issue Hook':
                $event = new Event\Issue($payload);
                break;
            case 'Merge Request Hook':
                $event = new Event\MergeRequest($payload);
                break;
            case 'Wiki Page Hook':
                $event = new Event\WikiPage($payload);
                break;
            case 'System Hook':
                if (isset($payload['object_kind']) && 'merge_request' === $payload['object_kind']) {
                    $event = new Event\MergeRequest($payload);
                } else {
                    switch ($payload['event_name']) {
                        case 'project_create':
                            $event = new Event\ProjectCreate($payload);
                            break;
                        case 'project_destroy':
                            $event = new Event\ProjectDestroy($payload);
                            break;
                        case 'project_rename':
                            $event = new Event\ProjectRename($payload);
                            break;
                        case 'project_transfer':
                            $event = new Event\ProjectTransfer($payload);
                            break;
                        case 'project_update':
                            $event = new Event\ProjectUpdate($payload);
                            break;
                        case 'user_add_to_team':
                            $event = new Event\TeamMemberAdd($payload);
                            break;
                        case 'user_remove_from_team':
                            $event = new Event\TeamMemberRemove($payload);
                            break;
                        case 'user_create':
                            $event = new Event\UserCreate($payload);
                            break;
                        case 'user_destroy':
                            $event = new Event\UserDestroy($payload);
                            break;
                        case 'user_failed_login':
                            $event = new Event\UserFailedLogin($payload);
                            break;
                        case 'user_rename':
                            $event = new Event\UserRename($payload);
                            break;
                        case 'key_create':
                            $event = new Event\KeyCreate($payload);
                            break;
                        case 'key_destroy':
                            $event = new Event\KeyDestroy($payload);
                            break;
                        case 'group_create':
                            $event = new Event\GroupCreate($payload);
                            break;
                        case 'group_destroy':
                            $event = new Event\GroupDestroy($payload);
                            break;
                        case 'group_rename':
                            $event = new Event\GroupRename($payload);
                            break;
                        case 'user_add_to_group':
                            $event = new Event\UserGroupAdd($payload);
                            break;
                        case 'user_remove_from_group':
                            $event = new Event\UserGroupRemove($payload);
                            break;
                        case 'tag_push':
                            $event = new Event\TagPush($payload);
                            break;
                        case 'push':
                            $event = new Event\Push($payload);
                            break;
                        default:
                            $event = new Event\Unknown($payload);
                    }
                }
                break;
            default:
                $event = new Event\Unknown($payload);
        }
        foreach ($this->listeners as $listener) {
            $listener->onEvent($event);
        }
    }
}
