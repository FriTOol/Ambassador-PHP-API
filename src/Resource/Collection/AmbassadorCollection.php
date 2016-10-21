<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 21/10/2016
 * Time: 13:43
 */

namespace AmbassadorApi\Resource\Collection;

use AmbassadorApi\Resource\Ambassador;

class AmbassadorCollection extends CollectionAbstract
{
    protected function _convertData()
    {
        foreach ($this->getRawData() as $rawData) {
            $this->_collection[] = new Ambassador($rawData, $this->getProxy());
        }
    }
}