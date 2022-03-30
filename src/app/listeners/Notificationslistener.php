<?php

namespace App\Listeners;

use Phalcon\Di\Injectable;
use Phalcon\Events\Event;

class Notificationslistener extends Injectable
{
    public function beforeHandleRequest(Event $event, \Phalcon\Mvc\Application $application)
    {
        $aclFile = APP_PATH . '/security/acl.cache';
        //if acl file exists
        if (is_file($aclFile)) {
            $acl = unserialize(file_get_contents($aclFile));
            $role = $application->request->get('role');
            if (!$role || !$acl->isAllowed($role, 'product', 'add')) {
                // header('location:/');
                echo "Acess Denied";
                die();
            }
        }
    }
}
