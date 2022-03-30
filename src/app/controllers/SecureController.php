<?php

use Phalcon\Mvc\Controller;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;


class SecureController extends Controller
{

    public function BuildACLAction()
    {
        $aclFile = APP_PATH . '/security/acl.cache';
        if (!is_file($aclFile)) {
            $acl = new Memory();

            $acl->addRole('admin');
            $acl->addRole('guest');

            $acl->addComponent(
                'product',
                [
                    'index',
                    'add',
                ]
            );
            $acl->allow('admin', 'product', '*');
            $acl->deny('guest', '*', '*');
            file_put_contents($aclFile, serialize($acl));
        } else {
            $acl = unserialize(file_get_contents($aclFile));
            print_r($acl);
        }
        echo is_file($aclFile) ? 'file exists' . '<br>' : 'file not exist' . '<br>';
        echo $acl->isAllowed('admin', 'product', 'index') ? 'access granted' : 'access denied';

        echo "<br>";

        die();
    }
}
