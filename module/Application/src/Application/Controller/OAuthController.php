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

class OAuthController extends AbstractActionController
{

    public function loginAction()
    {

        $channel = $this->params('channel', '');
        $model = $this->getSocialModel($channel);
        if (! isset($_GET['code'])) {
            return $this->notFoundAction();
        }
        $tokenArr = $model->getToken($_GET['code']);
        if (isset($tokenArr['access_token'])){

        }else{
            throw new \Exception(json_encode($tokenArr));
        }
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
}
