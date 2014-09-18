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
        $socialModel = $this->getSocialModel($channel);
        if (! isset($_GET['code'])) {
            return $this->notFoundAction();
        }
        $tokenArr = $socialModel->getToken($_GET['code']);
        var_dump($tokenArr);
        if (isset($tokenArr['access_token'])){
            $table = $this->getUserTable();
            try {
                $user = $table->getUserByWeiBoToken($tokenArr['access_token']);



            }catch (\Exception $e){
                $user = new User();
                $expiryAt = time() + $tokenArr['expires_in'];
                $user->weibo_token = $tokenArr['access_token'];
                $user->weibo_id = $tokenArr['uid'];
                $user->weibo_token_expiry = date('Y-m-d H:i:s', $expiryAt);
                $userInfo = $socialModel->getUserInfo($user->weibo_token, $user->weibo_id);
                $user->weibo_name = $userInfo['name'];
                $table->saveUser($user);
            }
        }else{
            throw new \Exception(json_encode($tokenArr));
        }
        exit();
    }

   /**
    *
    * @param string $channel
    * @return AbstractSocial
    */
    protected function getSocialModel($channel){
        $model = '';
        switch ($channel){
        	case 'weibo':
        	    $model = new Weibo();
        	    break;
        }
        return $model;
    }

    protected function getToken()
    {}

    public function testAction()
    {
    }
}
