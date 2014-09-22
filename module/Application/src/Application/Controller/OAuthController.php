<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Model\Account\Social\Weibo;
use Application\Model\Account\User;
use Application\Model\Account\UserAuthenticator;

class OAuthController extends AbstractActionController
{

    protected $userTable;

    public function getUserTable()
    {
        if (! $this->userTable) {
            $this->userTable = $this->getServiceLocator()->get('Application\Model\Account\UserTable');
        }

        return $this->userTable;
    }


    public function loginAction()
    {
        $channel = $this->params('channel', '');
        $model = '';
        switch ($channel){
        	case 'weibo':
        	    $this->doWeibo();
        	    break;
        }
        return $model;
    }


    public function doWeibo()
    {
        $authenticator = new UserAuthenticator();
        $socialModel = new Weibo();
        if (! isset($_GET['code'])) {
            return $this->notFoundAction();
        }
        $tokenArr = $socialModel->getToken($_GET['code']);
        if (isset($tokenArr['access_token'])){
            if(!$authenticator->existWeiboAccount($tokenArr['access_token']))
            {
                $user = new User();
                $expiryAt = time() + $tokenArr['expires_in'];
                $user->weibo_token = $tokenArr['access_token'];
                $user->weibo_id = $tokenArr['uid'];
                $user->weibo_token_expiry = date('Y-m-d H:i:s', $expiryAt);
                $userInfo = $socialModel->getUserInfo($user->weibo_token, $user->weibo_id);
                $user->weibo_name = $userInfo['name'];
                $user = $this->getUserTable()->saveUser($user);

            }
            $authenticator->doWeiboAuth($tokenArr['access_token']);
            $this->redirect()->toUrl('/store');
        }else{
            throw new \Exception(json_encode($tokenArr));
        }
        exit();
    }

    protected function getToken()
    {}

    public function testAction()
    {
    }
}
