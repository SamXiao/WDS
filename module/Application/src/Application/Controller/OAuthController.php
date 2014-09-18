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
use SamFramework\Core\App;
use Application\Model\Account\Social\Weibo;

class OAuthController extends AbstractActionController
{

    public function loginAction()
    {
        $channel = $this->params('channel', '');
//         $model = $this->getServiceLocator()->get('Application\Model\Account\Social\Weibo');
        $model = new Weibo();
        if (! isset($_GET['code'])) {
            return $this->notFoundAction();
        }
        $model->getToken($_GET['code']);
        exit();
//         echo $code;
    }

    protected function getToken()
    {}
}
