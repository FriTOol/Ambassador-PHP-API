<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 21/10/2016
 * Time: 14:11
 */

namespace AmbassadorApi\Resource;

use AmbassadorApi\Core\Proxy;
use AmbassadorApi\ProxyTrait;

abstract class ResourceAbstract
{
    use ProxyTrait, ResourceRawDataTrait;

    protected $_updatedData = [];

    protected $_isLoaded = false;

    public function __construct($rawData, Proxy $proxy, bool $isLoaded = false)
    {
        $this->setRawData($rawData);
        $this->setProxy($proxy);
        $this->_isLoaded = $isLoaded;
    }

    protected function _getData(string $name)
    {
        if (!isset($this->_updatedData[$name])) {
            return $this->_updatedData[$name];
        }

        return $this->getRawData()->$name;
    }
}