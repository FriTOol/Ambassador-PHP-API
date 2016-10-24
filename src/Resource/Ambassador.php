<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 21/10/2016
 * Time: 13:12
 */

namespace AmbassadorApi\Resource;

use AmbassadorApi\Resource\Collection\CampaignLinkCollection;
use AmbassadorApi\Resource\Collection\GroupCollection;

class Ambassador extends ResourceAbstract
{
    /**
     * @var Ambassador
     */
    private $_referringAmbassador;

    /**
     * @var CampaignLinkCollection
     */
    private $_campaignLinks;

    /**
     * @var GroupCollection
     */
    private $_groups;

    public function getId()
    {
        return $this->getRawData()->uid;
    }

    public function getFirstName(): string
    {
        return strval($this->getRawData()->first_name);
    }

    public function getLastName(): string
    {
        return strval($this->getRawData()->last_name);
    }

    public function getFullName(): string
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getEmail(): string
    {
        return $this->getRawData()->email;
    }

    public function getPaypalEmail(): string
    {
        return $this->getRawData()->paypal_email;
    }

    public function getBalanceMoney(): float
    {
        return floatval($this->getRawData()->balance_money);
    }

    public function getBalancePoints(): float
    {
        return floatval($this->getRawData()->balance_points);
    }

    public function getMoneyPaid(): float
    {
        return floatval($this->getRawData()->money_paid);
    }

    public function getPointsPaid(): float
    {
        return floatval($this->getRawData()->points_paid);
    }

    public function getMemorableUrl(): string
    {
        return $this->getRawData()->memorable_url;
    }

    public function getUniqueReferrals(): int
    {
        return intval($this->getRawData()->unique_referrals);
    }

    public function isSandbox(): bool
    {
        return $this->getRawData()->sandbox == '1';
    }

    public function getCreatedAt(): \DateTime
    {
        return new \DateTime($this->getRawData()->created_at);
    }

    public function getFraudScore(): int
    {
        return intval($this->getRawData()->fraud_score);
    }

    public function getFraudScoreHumanReadable(): string
    {
        return $this->getRawData()->fraud_score_human_readable;
    }

    public function getFraudScorePercentUi(): int
    {
        return intval($this->getRawData()->fraud_score_percent_ui);
    }

    public function getFraudReasons()
    {
        return $this->getRawData()->fraud_reasons;
    }

    public function getCustom1()
    {
        return $this->getRawData()->custom1;
    }

    public function getCustom2()
    {
        return $this->getRawData()->custom2;
    }

    public function getCustom3()
    {
        return $this->getRawData()->custom3;
    }

    public function getGroupIds(): array
    {
        if (!isset($this->getRawData()->groups)) {
            return [];
        }

        return explode(',', $this->getRawData()->groups);
    }

    public function getStreet(): string
    {
        return $this->getRawData()->street;
    }

    public function getCity(): string
    {
        return $this->getRawData()->city;
    }

    public function getState(): string
    {
        return $this->getRawData()->state;
    }

    public function getZip(): string
    {
        return $this->getRawData()->zip;
    }

    public function getCountry(): string
    {
        return $this->getRawData()->country;
    }

    public function getPhone(): string
    {
        return $this->getRawData()->phone;
    }

    public function getCompany(): string
    {
        return $this->getRawData()->company;
    }

    public function getCampaignLinks(): CampaignLinkCollection
    {
        $this->_load();

        if (!isset($this->getRawData()->campaign_links)) {
            return new CampaignLinkCollection([], $this->getProxy());
        }
        if (is_null($this->_campaignLinks)) {
            $this->_campaignLinks = new CampaignLinkCollection($this->getRawData()->campaign_links, $this->getProxy());
        }

        return $this->_campaignLinks;
    }

    /**
     * @return Ambassador
     */
    public function getReferringAmbassador(): Ambassador
    {
        $this->_load();

        return $this->_referringAmbassador;
    }

    /**
     * @param Ambassador $referringAmbassador
     */
    public function setReferringAmbassador(Ambassador $referringAmbassador)
    {
        $this->_referringAmbassador = $referringAmbassador;
    }

    public function hasReferring(): bool
    {
        $this->_load();

        return $this->_referringAmbassador != null;
    }

    public function _load()
    {
        if (!$this->_isLoaded)
        {
            $this->setRawData($this->getProxy()->getAmbassadorByEmail($this->getEmail()));
            $this->_isLoaded = true;
        }
    }

    public function getGroups(): GroupCollection
    {
        if (is_null($this->_groups)) {
            if (isset($this->getGroupIds()->groups)) {
                $this->_groups = new GroupCollection($this->getProxy()->getGroupsByIds($this->getGroupIds())->groups, $this->getProxy());
            } else {
                $this->_groups = new GroupCollection([], $this->getProxy());
            }
        }

        return $this->_groups;
    }
}