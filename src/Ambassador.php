<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 21/10/2016
 * Time: 12:41
 */

namespace AmbassadorApi;

use AmbassadorApi\Core\Proxy;
use AmbassadorApi\Resource\Ambassador as AmbassadorResource;
use AmbassadorApi\Resource\Collection\AmbassadorCollection;
use AmbassadorApi\Resource\Collection\CommissionCollection;
use AmbassadorApi\Resource\Collection\GroupCollection;
use AmbassadorApi\Resource\Company;

class Ambassador
{
    /**
     * @var Proxy
     */
    private $_proxy;

    private $_defaultConfigs = [
        'http_client' => [
            'timeout' => 3,
            'allow_redirects' => true,
        ]
    ];

    public function __construct(string $username, string $key, string $domain, array $configs = [])
    {
        $configs = array_merge($this->_defaultConfigs, $configs);
        $this->_proxy = new Proxy($username, $key, $domain, $configs);
    }

    public function getProxy(): Proxy
    {
        return $this->_proxy;
    }

    public function getAmbassadors(array $params = [])
    {
        $data = $this->getProxy()->getAmbassadors($params);
        return new AmbassadorCollection($data->ambassadors, $this->getProxy());
    }

    public function getAmbassadorByEmail(string $email)
    {
        $data = $this->getProxy()->getAmbassadorByEmail($email);

        $ambassadorResource = new AmbassadorResource($data->ambassador, $this->getProxy(), true);
        if (!is_null($data->referring_ambassador) && !is_null($data->referring_ambassador->email)) {
            $ambassadorResource->setReferringAmbassador(new AmbassadorResource($data->referring_ambassador, $this->getProxy()));
        }

        return $ambassadorResource;
    }

    public function getGroups()
    {
        $data = $this->getProxy()->getGroups();
        return new GroupCollection($data->groups, $this->getProxy());
    }

    public function getCompany()
    {
        return new Company($this->getProxy()->getCompany(), $this->getProxy());
    }

    public function getCommissions(array $params = [])
    {
        $data = $this->getProxy()->getCommissions($params);

        return new CommissionCollection($data->commissions, $this->getProxy());
    }

    public function updateAmbassador(array $data)
    {
        $this->getProxy()->updateAmbassador($data);
    }

    public function createEvent(array $data)
    {
        $this->getProxy()->createEvent($data);
    }

    public function getCompanyToken(): string
    {
        return $this->getProxy()->getCompanyToken();
    }

    public function getSsoLoginUrl(string $email): string
    {
        return $this->getProxy()->getSsoLoginUrl($email);
    }
}