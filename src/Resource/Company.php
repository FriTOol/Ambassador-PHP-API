<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 21/10/2016
 * Time: 20:41
 */

namespace AmbassadorApi\Resource;

use AmbassadorApi\Resource\Collection\CampaignCollection;
use AmbassadorApi\Resource\Collection\CampaignLinkCollection;

class Company extends ResourceAbstract
{
    /**
     * @var CampaignLinkCollection
     */
    private $_campaigns;

    public function getName(): string
    {
        return $this->getRawData()->company->company_name;
    }

    public function getUrl(): string
    {
        return $this->getRawData()->company->company_url;
    }

    public function getEmail(): string
    {
        return $this->getRawData()->company->company_email;
    }

    public function getOutgoingEmail(): string
    {
        return $this->getRawData()->company->outgoing_email;
    }

    public function getPointName(): string
    {
        return $this->getRawData()->company->point_name;
    }

    public function getCampaigns()
    {
        if (is_null($this->_campaigns)) {
            $this->_campaigns = new CampaignCollection($this->getRawData()->campaigns, $this->getProxy());
        }

        return $this->_campaigns;
    }
}