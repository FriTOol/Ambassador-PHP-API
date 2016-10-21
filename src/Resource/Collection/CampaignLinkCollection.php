<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 21/10/2016
 * Time: 18:27
 */

namespace AmbassadorApi\Resource\Collection;

use AmbassadorApi\Resource\CampaignLink;

class CampaignLinkCollection extends CollectionAbstract
{
    protected function _convertData()
    {
        foreach ($this->getRawData() as $rawData) {
            $this->_collection[] = new CampaignLink($rawData, $this->getProxy());
        }
    }
}