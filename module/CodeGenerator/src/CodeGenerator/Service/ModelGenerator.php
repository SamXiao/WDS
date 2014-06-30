<?php
namespace CodeGenerator\Service;

use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Db\Metadata\Metadata;

class ModelGenerator
{

    public $nameSpace;

    public $className;

    public $tableName;

    protected $tableCols;

    protected $dbAdapter;

    protected $_exchangeArrayMethodTemplate = '$this-><{$colName}> = (!empty($data[\'<{$colName}>\'])) ? $data[\'<{$colName}>\'] : null;';
    protected $_toArrayMethodTemplate = '(!empty($this-><{$colName}>)) ? $data[\'<{$colName}>\'] = $this-><{$colName}> : null;';

    public function __construct($dbAdapter, $className, $nameSpace, $tableName)
    {
        $this->dbAdapter = $dbAdapter;
        $this->className = $className;
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

        $cols = $this->getTabelCols();
        foreach ($cols as $col) {
            if (! $class->hasProperty($col->getName())) {
                $class->addProperty($col->getName(), '', 'public');
            }
        }

        $class->addMethodFromGenerator($this->generateExchangeArrayMethod());
        $class->addMethodFromGenerator($this->generateToArrayMethod());
        return $class;
    }

    protected function generateExchangeArrayMethod()
    {
        $method = new MethodGenerator();
        $cols = $this->getTabelCols();
        $methodBody = '';
        foreach ($cols as $col) {
            $methodBody .= str_replace('<{$colName}>', $col->getName(), $this->_exchangeArrayMethodTemplate) . PHP_EOL;
        }
        $method->setName('exchangeArray')
            ->setParameter('data')
            ->setBody($methodBody);
        return $method;
    }

    protected function generateToArrayMethod()
    {
        $method = new MethodGenerator();
        $cols = $this->getTabelCols();
        $methodBody = '$data = array();' . PHP_EOL;
        foreach ($cols as $col) {
            $methodBody .= str_replace('<{$colName}>', $col->getName(), $this->_toArrayMethodTemplate) . PHP_EOL;
        }
        $methodBody .= 'return $data;' . PHP_EOL;
        $method->setName('toArray')
            ->setParameter('data')
            ->setBody($methodBody);
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
}

