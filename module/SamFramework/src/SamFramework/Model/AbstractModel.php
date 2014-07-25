<?php
namespace SamFramework\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
abstract class AbstractModel  implements InputFilterAwareInterface
{
    protected $inputFilter;

    public function __get($name)
    {
        $thisClassName = get_class($this);
        $getter = 'get' . ucfirst($name);
        if (method_exists($thisClassName, $getter)) {
            return $this->$getter();
        } else
            if (property_exists($thisClassName, $name)) {
                return $this->$name;
            }
        throw new \Exception("Property \"{$thisClassName}.{$name}\" is not defined.");
    }

    public function __set($name, $value)
    {
        $thisClassName = get_class($this);
        $setter = 'set' . ucfirst($name);
        $getter = 'get' . ucfirst($name);
        if (method_exists($thisClassName, $setter)) {
            return $this->$setter($value);
        } else
            if (property_exists($thisClassName, $name)) {
                return $this->$name = $value;
            }
        if (method_exists($thisClassName, $getter)) {
            throw new \Exception("Property \"{$thisClassName}.{$name}\" is read only.");
        } else {
            throw new \Exception("Property \"{$thisClassName}.{$name}\" is not defined.");
        }
    }

    public function __isset($name)
    {
        $thisClassName = get_class($this);
        $getter = 'get' . $name;
        if (method_exists($thisClassName, $getter))
            return $this->$getter() !== null;
        else
            if (property_exists($thisClassName, $name)) {
                return $this->$name !== null;
            }
        return false;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Please set InputFilter");
    }

    public function getInputFilter()
    {
        throw new \Exception("Please set InputFilter");
    }
}
