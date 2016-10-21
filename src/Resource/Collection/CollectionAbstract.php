<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 21/10/2016
 * Time: 13:49
 */

namespace AmbassadorApi\Resource\Collection;

use AmbassadorApi\ProxyTrait;
use AmbassadorApi\Resource\ResourceRawDataTrait;

abstract class CollectionAbstract implements \IteratorAggregate, \Countable, \ArrayAccess
{
    use ResourceRawDataTrait, ProxyTrait;

    /**
     * @var array
     */
    protected $_collection;

    abstract protected function _convertData();

    public function __construct($rawData, $ambassador)
    {
        $this->setRawData($rawData);
        $this->setProxy($ambassador);
        $this->_convertData();
    }

    public function count()
    {
        return count($this->_collection);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->_collection);
    }

    public function offsetExists($offset)
    {
        return isset($this->_collection[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->_collection[$offset];
    }

    public function offsetSet($offset, $value)
    {
        trigger_error("You can't set collection data");
    }

    public function offsetUnset($offset)
    {
        unset($this->_collection[$offset]);
    }

}