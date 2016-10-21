<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 21/10/2016
 * Time: 13:46
 */

namespace AmbassadorApi;


use AmbassadorApi\Core\Proxy;

trait ProxyTrait
{
    /**
     * @var Proxy
     */
    protected $_proxy;

    /**
     * @return Proxy
     */
    public function getProxy(): Proxy
    {
        return $this->_proxy;
    }

    /**
     * @param Proxy $proxy
     */
    public function setProxy(Proxy $proxy)
    {
        $this->_proxy = $proxy;
    }
}