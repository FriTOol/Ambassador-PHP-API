<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 21/10/2016
 * Time: 18:59
 */

namespace AmbassadorApi\Resource;

class Campaign extends ResourceAbstract
{
    public function getId(): string
    {
        return $this->getRawData()->campaign_uid;
    }

    public function getName(): string
    {
        return $this->getRawData()->campaign_name;
    }

    public function getDescription(): string
    {
        return $this->getRawData()->campaign_description;
    }

    public function getInitialReward()
    {
        return $this->getRawData()->initial_reward;
    }

    public function getRecurringReward()
    {
        return $this->getRawData()->recurring_reward;
    }

    public function getLandingPage()
    {
        return $this->getRawData()->landing_page;
    }

    public function isSandbox(): bool
    {
        return $this->getRawData()->sandbox == '1';
    }

    public function isPrivate(): bool
    {
        return $this->getRawData()->private == '1';
    }

    public function isFacebookEnabled(): bool
    {
        return $this->getRawData()->facebook_enabled == '1';
    }

    public function isAutoApproveCommissions(): bool
    {
        return $this->getRawData()->auto_approve_commissions == '1';
    }

    public function getDiscountValue(): string
    {
        return $this->getRawData()->discount_value;
    }

    public function getStartDate(): \DateTime
    {
        return (new \DateTime())->setTimestamp($this->getRawData()->start_date);
    }

    public function getEndDate(): \DateTime
    {
        return (new \DateTime())->setTimestamp($this->getRawData()->end_date);
    }

    public function hasEndDate(): bool
    {
        return !is_null($this->getRawData()->end_date);
    }

    public function getUserMessage(): string
    {
        return $this->getRawData()->user_message;
    }

    public function getCompanyMessage(): string
    {
        return $this->getRawData()->company_message;
    }

    public function getSubject(): string
    {
        return $this->getRawData()->subject;
    }

    public function getSocialMessage(): string
    {
        return $this->getRawData()->social_message;
    }
}
