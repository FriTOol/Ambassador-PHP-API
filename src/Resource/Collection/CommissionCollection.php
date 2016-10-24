<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 24/10/2016
 * Time: 19:28
 */

namespace AmbassadorApi\Resource\Collection;

use AmbassadorApi\Resource\Commission;

class CommissionCollection extends CollectionAbstract
{
    protected function _convertData()
    {
        foreach ($this->getRawData() as $rawData) {
            $this->_collection[] = new Commission($rawData, $this->getProxy());
        }
    }
}