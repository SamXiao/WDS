<?php
namespace CodeGenerator\Service;

use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Db\Metadata\Metadata;
use Zend\Code\Generator\ParameterGenerator;
use Zend\Code\Generator\PropertyGenerator;

class ModelMapperGenerator
{

    public $nameSpace;

    public $className;

    public $modelClassName;

    public $tableName;

    protected $tableCols;

    protected $dbAdapter;

    protected $_fetchAllMethodTemplate = '$resultSet = $this->tableGateway->select();
return $resultSet;';

    protected $_toArrayMethodTemplate = '(!empty($this-><{$colName}>)) ? $data[\'<{$colName}>\'] = $this-><{$colName}> : null;';

    protected $_updateMethodTemplate = '$data = $<{$paramName}>->toArray();
 $id = (int) $<{$paramName}>->id;
 if ($id == 0) {
     $this->tableGateway->insert($data);
 } else {
     if ($this->get<{$model}>($id)) {
         $this->tableGateway->update($data, array(\'id\' => $id));
     } else {
         throw new \Exception(\'Album id does not exist\');
     }
 }';

    public function __construct($dbAdapter, $modelName, $nameSpace, $tableName)
    {
        $this->dbAdapter = $dbAdapter;
        $this->className = $modelName . 'Table';
        $this->modelClassName = $modelName;
        $this->nameSpace = $nameSpace;
        $this->tableName = $tableName;
    }

    /**
     *
     * @return \CodeGenerator\Service\ClassGenerator
     */
    public function generate()
    {
        $class = new ClassGenerator($this->className, $this->nameSpace);

        $class->addUse('Zend\Db\TableGateway\TableGateway');
        $class->addUse('Zend\ServiceManager\ServiceManager');
        $class->addUse('Zend\Db\ResultSet\ResultSet;');
        $class->addProperty('serviceManager', null, PropertyGenerator::FLAG_PROTECTED);
        $class->addProperty('tableGateway', null, PropertyGenerator::FLAG_PROTECTED);
        $class->addProperty('TABLE_NAME', $this->tableName, PropertyGenerator::FLAG_CONSTANT);

        $class->addMethodFromGenerator($this->generateConstructMethod());
        $class->addMethodFromGenerator($this->generateFetchAllMethod());
        $class->addMethodFromGenerator($this->generateGetModelMethod());
        $class->addMethodFromGenerator($this->generateSaveModelMethod());
        $class->addMethodFromGenerator($this->generateDeleteMethod());

        return $class;
    }

    protected function generateConstructMethod()
    {
        $method = new MethodGenerator();
        $method->setName('__construct');
        $method->setParameter(new ParameterGenerator('serviceManager', 'ServiceManager'));
        $method->setBody('$this->serviceManager = $serviceManager;
$dbAdapter = $serviceManager->get(\'Zend\Db\Adapter\Adapter\');
$resultSetPrototype = new ResultSet();
$resultSetPrototype->setArrayObjectPrototype(new Project());
$this->tableGateway = new TableGateway(self::TABLE_NAME, $dbAdapter, null, $resultSetPrototype);');
        return $method;
    }

    protected function generateFetchAllMethod()
    {
        $method = new MethodGenerator();
        $method->setName('fetchAll');
        $method->setBody($this->_fetchAllMethodTemplate);
        return $method;
    }

    protected function getTabelCols()
    {
        if (empty($this->tableCols)) {
            $metadata = new Metadata($this->dbAdapter);
            $table = $metadata->getTable($this->tableName);
            $this->tableCols = $table->getColumns();
        }
        return $this->tableCols;
    }

    protected function generateGetModelMethod()
    {
        $method = new MethodGenerator();
        $method->setName('get' . $this->modelClassName);
        $body = '$id  = (int) $id;
 $rowset = $this->tableGateway->select(array(\'id\' => $id));
 $row = $rowset->current();
 if (!$row) {
     throw new \Exception("Could not find row $id");
 }
 return $row;';
        $method->setBody($body);
        return $method;
    }

    protected function generateSaveModelMethod()
    {
        $method = new MethodGenerator();
        $method->setName('save' . $this->modelClassName);
        $method->setParameter(new ParameterGenerator(lcfirst($this->modelClassName), $this->modelClassName));
        $body = str_replace('<{$paramName}>', lcfirst($this->modelClassName), $this->_updateMethodTemplate);
        $body = str_replace('<{$model}>', $this->modelClassName, $body);
        $method->setBody($body);
        return $method;
    }

    protected function generateDeleteMethod()
    {
        $method = new MethodGenerator();
        $method->setName('delete' . $this->modelClassName);
        $body = '$this->tableGateway->delete(array(\'id\' => (int) $id));';
        $method->setBody($body);
        return $method;
    }
}

