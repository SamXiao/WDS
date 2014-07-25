<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Mobile\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;



class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $categoryTable = $this->getCategoryTable();
        $categories = $categoryTable->fetchAll();
        return array(
        	'categories' => $categories
        );
    }

    protected function getCategoryTable()
    {
        return $this->getServiceLocator()->get('Mobile\Model\CategoryTable');
    }
}
