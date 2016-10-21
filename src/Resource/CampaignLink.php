<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 21/10/2016
 * Time: 18:28
 */

namespace AmbassadorApi\Resource;

class CampaignLink extends ResourceAbstract
{
    /**
     * @var Campaign
     */
    private $_campaign;

    /**
     * @return Campaign
     */
    public function getCampaign(): Campaign
    {
        if (is_null($this->_campaign)) {
            $this->_campaign = new Campaign($this->getRawData(), $this->getProxy());
        }

        return $this->_campaign;
    }

    public function getUrl(): string
    {
        return $this->getRawData()->url;
    }

    public function getTotalMoneyEarned(): float
    {
        return floatval($this->getRawData()->total_money_earned);
    }

    public function getTotalPointsEarned(): int
    {
        return intval($this->getRawData()->total_points_earned);
    }
}