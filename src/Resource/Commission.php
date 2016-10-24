<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 24/10/2016
 * Time: 19:28
 */

namespace AmbassadorApi\Resource;


class Commission extends ResourceAbstract
{
    public function getId(): string
    {
        return $this->getRawData()->commission_uid;
    }

    public function getCampaign(): Campaign
    {
        $data = new \ArrayObject(['campaign_uid' => $this->getRawData()->campaign_uid]);

        return new Campaign($this->getRawData($data), $this->getProxy());
    }

    public function getAffiliateId(): string
    {
        return $this->getRawData()->affiliate_uid;
    }

    public function getAffiliate(): Ambassador
    {
        //@TODO
    }

    public function getReferringId(): string
    {
        return $this->getRawData()->referring_uid;
    }

    public function getReferring(): Ambassador
    {
        //@TODO
    }

    public function getRemoteCustomerEmail(): string
    {
        return $this->getRawData()->remote_customer_email;
    }

    public function getAffiliateEmail(): string
    {
        return $this->getRawData()->affiliate_email;
    }

    public function getRevenueAmount(): float
    {
        return floatval($this->getRawData()->revenue_amount);
    }

    public function getCommissionAmount(): float
    {
        return floatval($this->getRawData()->commission_amount);
    }

    public function getCreatedAt(): \DateTime
    {
        return new \DateTime($this->getRawData()->created_at);
    }

    public function getTransactionId(): string
    {
        return $this->getRawData()->transaction_id;
    }

    public function isApproved(): bool
    {
        return $this->getRawData()->is_approved == '1';
    }

    public function isSandbox(): bool
    {
        return $this->getRawData()->is_sandbox == '1';
    }

    public function isTrial(): bool
    {
        return $this->getRawData()->is_trial == '1';
    }
}
