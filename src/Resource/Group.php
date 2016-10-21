<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 21/10/2016
 * Time: 19:45
 */

namespace AmbassadorApi\Resource;

class Group extends ResourceAbstract
{
    public function getId(): int
    {
        return intval($this->getRawData()->group_id);
    }

    public function getName(): string
    {
        return $this->getRawData()->name;
    }

    public function getDescription(): string
    {
        return $this->getRawData()->description;
    }

    public function isDefault(): bool
    {
        return $this->getRawData()->default == '1';
    }
}