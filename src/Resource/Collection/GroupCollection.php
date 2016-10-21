<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 21/10/2016
 * Time: 19:45
 */

namespace AmbassadorApi\Resource\Collection;

use AmbassadorApi\Resource\Group;

class GroupCollection extends CollectionAbstract
{
    protected function _convertData()
    {
        foreach ($this->getRawData() as $rawData) {
            $this->_collection[] = new Group($rawData, $this->getProxy());
        }
    }
}