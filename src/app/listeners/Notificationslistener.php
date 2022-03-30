<?php

namespace App\Listeners;

use Phalcon\Di\Injectable;
use Phalcon\Events\Event;

class Notificationslistener extends Injectable
{
    public function beforeHandleRequest(Event $event, \Phalcon\Mvc\Application $application)
    {
        $aclFile = APP_PATH . '/security/acl.cache';

        // get controller and action name
        $getData = explode("/", $this->request->getQuery()['_url']);
        $controllerName = $getData[1];
        $actionName = isset($getData[2]) ? $getData[2] : 'index';
        //if acl file exists
        if (is_file($aclFile)) {
            $acl = unserialize(file_get_contents($aclFile));
            $role = $application->request->get('role');
            if (!$role || !$acl->isAllowed($role, $controllerName, $actionName)) {
                // header('location:/');
                echo "Acess Denied" . $role;
                die();
            }
        }
    }
}
