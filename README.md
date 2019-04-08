[![Latest Stable Version](https://poser.pugx.org/thecodingmachine/gitlab-hook-middleware/v/stable.svg)](https://packagist.org/packages/thecodingmachine/gitlab-hook-middleware)
[![Total Downloads](https://poser.pugx.org/thecodingmachine/gitlab-hook-middleware/downloads.svg)](https://packagist.org/packages/thecodingmachine/gitlab-hook-middleware)
[![Latest Unstable Version](https://poser.pugx.org/thecodingmachine/gitlab-hook-middleware/v/unstable.svg)](https://packagist.org/packages/thecodingmachine/gitlab-hook-middleware)
[![License](https://poser.pugx.org/thecodingmachine/gitlab-hook-middleware/license.svg)](https://packagist.org/packages/thecodingmachine/gitlab-hook-middleware)
[![Build Status](https://travis-ci.org/thecodingmachine/gitlab-hook-middleware.svg?branch=master)](https://travis-ci.org/thecodingmachine/gitlab-hook-middleware)
[![Coverage Status](https://coveralls.io/repos/thecodingmachine/gitlab-hook-middleware/badge.svg?branch=master&service=github)](https://coveralls.io/github/thecodingmachine/gitlab-hook-middleware?branch=master)

Gitlab hook PSR-15 middleware
=============================

This package is a PSR-15 Middleware to receive events sent by a Gitlab webhook and send them to a listener.

It's possible to use directly the hookReceiver to build the event object, but you could check the Gitlab authentification.

How does it work
----------------

The middleware checks the header named X-GITLAB-TOKEN and builds an event object. The object is dispatched to a listener 
that you must implement.

The middleware takes care of unserializing the payload and provides you with nice PHP objects instead of raw JSON data.
It's possible to get the initial array payload with the getPayload() function.

Your listener will receive all events. If you want to listen on a specific event type, you must check the object type.

Event List:

|Scope|Hook|Header|Object|
|-----|----|------|------|
|Project|Push Hook|Push Hook|TheCodingMachine\GitlabHook\Model\Push|
|Project|Tag Push Hook|Tag Push Hook|TheCodingMachine\GitlabHook\Model\TagPush|
|Project|Note Hook|Note Hook|*Not implemented*|
|Project|Pipeline Hook|Pipeline Hook|TheCodingMachine\GitlabHook\Model\Pipeline|
|Project|Build Hook|Build Hook|TheCodingMachine\GitlabHook\Model\Build|
|Group|Project created|System Hook|TheCodingMachine\GitlabHook\Model\ProjectCreate|
|Group|Project destroyed|System Hook|TheCodingMachine\GitlabHook\Model\ProjectDestroy|
|Group|Project renamed|System Hook|TheCodingMachine\GitlabHook\Model\ProjectRename|
|Group|Project transferred|System Hook|TheCodingMachine\GitlabHook\Model\ProjectTrasnfer|
|Group|New Team Member|System Hook|TheCodingMachine\GitlabHook\Model\TeamMemberAdd|
|Group|Team Member Removed|System Hook|TheCodingMachine\GitlabHook\Model\TeamMemberRemove|
|Group|User created|System Hook|TheCodingMachine\GitlabHook\Model\UserCreate|
|Group|User removed|System Hook|TheCodingMachine\GitlabHook\Model\UserDestroy|
|Group|User failed login|System Hook|TheCodingMachine\GitlabHook\Model\UserFailedLogin|
|Group|User renamed|System Hook|TheCodingMachine\GitlabHook\Model\UserRename|
|Group|Key added|System Hook|TheCodingMachine\GitlabHook\Model\KeyCreate|
|Group|Key removed|System Hook|TheCodingMachine\GitlabHook\Model\KeyDestroy|
|Group|Group created|System Hook|TheCodingMachine\GitlabHook\Model\GroupCreate|
|Group|Group removed|System Hook|TheCodingMachine\GitlabHook\Model\GroupDestroy|
|Group|Group renamed|System Hook|TheCodingMachine\GitlabHook\Model\GroupRename|
|Group|New Group Member|System Hook|TheCodingMachine\GitlabHook\Model\UserGroupAdd|
|Group|Group Member Removed|System Hook|TheCodingMachine\GitlabHook\Model\UserGroupRemove|
|Group|Push events|System Hook|TheCodingMachine\GitlabHook\Model\Push|
|Group|Tag events|System Hook|TheCodingMachine\GitlabHook\Model\Tag|
|Group|Merge request events|System Hook|TheCodingMachine\GitlabHook\Model\MergeRequest|
|Group|Repository Update events|System Hook|TheCodingMachine\GitlabHook\Model\RepositoryUpdate|


Example
-------

Listener implementation
```php
<?php
namespace Test;

class Listener implements HookListenerInterface {
    /**
     * @param \TheCodingMachine\GitlabHook\EventInterface $event
     */
     public function onEvent(EventInterface $event) {
         // Compute Push event
         if($event instanceof TheCodingMachine\GitlabHook\Model\Push::class) {
             // Display before
             echo $event->getBefore();
             // Display the project name
             echo $event->getProject()->getName();
         }
         // Compute MergeRequest event
         if($event instanceof TheCodingMachine\GitlabHook\Model\MergeRequest::class) {
             // Display target branch (this is in object_attributes)
             echo $event->getTargetBranch();
             // Get initial payload
             var_dump($event->getPayload());
         }
     }
}
?>
``` 

Use without middleware

```php

// Create your listener
$listener = new Test\Listerner();

// Register your listener in the main HookReceiver instance
$hookReceiver = new TheCodingMachine\GitlabHook\HookReceiver([$listener]);

// Call handler function to execute check
// $payload is array (json_decode) of data send by Gitlab webhook
// $header is the result of HTTP_X_GITLAB_TOKEN header 
$hookReceiver->handle($payload, $header);
```

Use a middleware
```php

// Create your listener
$listener = new Test\Listerner();

// Register your listener in the main HookReceiver instance
$hookReceiver = new TheCodingMachine\GitlabHook\HookReceiver([$listener]);

// Create a PSR-3 logger
$logger = new Psr\Log\NullLogger(); 

// Inject hookReceiver in Gitlab middleware
// You must inject this middleware in the middleware pipe of your favorite framework.
// See your framework documentation on how to do that.
$middleware = new TheCodingMachine\GitlabHook\GitlabHookMiddleware($hookReceiver, 'secret', $logger);
```


















