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

    protected $_isLoaded = false;

    public function __construct($rawData, Proxy $proxy, bool $isLoaded = false)
    {
        $this->setRawData($rawData);
        $this->setProxy($proxy);
        $this->_isLoaded = $isLoaded;
    }

    public function save()
    {

    }
}