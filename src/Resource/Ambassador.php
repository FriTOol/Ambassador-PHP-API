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
        if (!isset($this->_updatedData['new_uid'])) {
            return $this->_updatedData['new_uid'];
        }

        $this->_load();

        return $this->getRawData()->platform_id;
    }

    public function setId($id): Ambassador
    {
        $this->_updatedData['new_uid'] = $id;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->_getData('first_name');
    }

    public function setFirstName(string $firstName): Ambassador
    {
        $this->_updatedData['first_name'] = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->_getData('last_name');
    }

    public function setLastName(string $lastName): Ambassador
    {
        $this->_updatedData['last_name'] = $lastName;

        return $this;
    }

    public function getFullName(): string
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getEmail(): string
    {
        return $this->_getData('email');
    }

    public function setEmail(string $email): Ambassador
    {
        $this->_updatedData['new_email'] = $email;

        return $this;
    }

    public function getPaypalEmail(): string
    {
        return $this->_getData('paypal_email');
    }

    public function setPaypalEmail(string $paypalEmail): Ambassador
    {
        $this->_updatedData['paypal_email'] = $paypalEmail;

        return $this;
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

    public function setStreet(string $street): Ambassador
    {
        $this->_updatedData['street'] = $street;

        return $this;
    }

    public function getCity(): string
    {
        return $this->getRawData()->city;
    }


    public function setCity(string $city): Ambassador
    {
        $this->_updatedData['city'] = $city;

        return $this;
    }

    public function getState(): string
    {
        return $this->getRawData()->state;
    }

    public function setState(string $state): Ambassador
    {
        $this->_updatedData['state'] = $state;

        return $this;
    }

    public function getZip(): string
    {
        return $this->getRawData()->zip;
    }

    public function setZip(string $zip): Ambassador
    {
        $this->_updatedData['zip'] = $zip;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->getRawData()->country;
    }

    public function setCountry(string $country): Ambassador
    {
        $this->_updatedData['country'] = $country;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->getRawData()->phone;
    }

    public function setPhone(string $phone): Ambassador
    {
        $this->_updatedData['phone'] = $phone;

        return $this;
    }

    public function getCompany(): string
    {
        return $this->getRawData()->company;
    }

    public function setCompany(string $company): Ambassador
    {
        $this->_updatedData['company'] = $company;

        return $this;
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
        if (!$this->_isLoaded) {
            $data = $this->getProxy()->getAmbassadorByEmail($this->getEmail());
            $this->setRawData($data->ambassador);
            if (isset($data->referring_ambassador) && !is_null($data->referring_ambassador->email)) {
                $this->setReferringAmbassador(new Ambassador($data->referring_ambassador, $this->getProxy()));
            }
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

    public function setSendWelcomeEmail(bool $isSend): Ambassador
    {
        $this->_updatedData['send_welcome_email'] = $isSend ? '1' : '0';

        return $this;
    }

    public function setIsDeactivated(bool $isDeactivated): Ambassador
    {
        $this->_updatedData['is_deactivated'] = $isDeactivated ? '1' : '0';

        return $this;
    }

    public function save()
    {
        $data = $this->_updatedData;
        $data['email'] = $this->getRawData()->email;
        $this->getProxy()->updateAmbassador($data);
    }
}