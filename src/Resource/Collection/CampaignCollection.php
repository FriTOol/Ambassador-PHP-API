<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 21/10/2016
 * Time: 20:45
 */

namespace AmbassadorApi\Resource\Collection;

use AmbassadorApi\Resource\Campaign;

class CampaignCollection extends CollectionAbstract
{
    protected function _convertData()
    {
        foreach ($this->getRawData() as $rawData) {
            $this->_collection[] = new Campaign($rawData, $this->getProxy());
        }
    }
}