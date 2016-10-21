<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 21/10/2016
 * Time: 17:26
 */

namespace AmbassadorApi\Core;

use AmbassadorApi\Exception\AmbassadorNotFoundException;
use AmbassadorApi\Exception\InternalServerErrorException;
use AmbassadorApi\Exception\NotFound;
use AmbassadorApi\Exception\NotFoundException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Proxy
{
    const BASE_URL = 'https://getambassador.com/api/v2/%s/%s/json/';

    /**
     * @var string
     */
    private $_apiUsername = '';

    /**
     * @var string
     */
    private $_apiKey = '';

    private $_httpClient;

    public function __construct(string $username, string $key, array $configs = [])
    {
        $this->_apiUsername = $username;
        $this->_apiKey = $key;
        $configs['http_client']['base_uri'] = sprintf(self::BASE_URL, $this->_apiUsername, $this->_apiKey);
        $this->_httpClient = new Client($configs['http_client']);
    }

    public function getAmbassadors(array $params = [])
    {
        return $this->_callApi('ambassador/all/', $params);
    }

    public function getAmbassador(array $params)
    {
        return $this->_callApi('ambassador/get/', $params);
    }

    public function getAmbassadorByEmail(string $email)
    {
        try {
            return $this->getAmbassador(['email' => $email]);
        } catch (NotFoundException $exception) {
            throw new AmbassadorNotFoundException(
                sprintf('Ambassador with email "%s" not found.', $email),
                $exception->getCode()
            );
        }
    }

    public function getGroups()
    {
        return $this->_callApi('group/all/');
    }

    public function getGroupsByIds($groupIds)
    {
        $groups = clone $this->getGroups();

        foreach ($groups->groups as $index => $group) {
            if (!in_array($group->group_id, $groupIds)) {
                unset($groups->groups[$index]);
            }
        }

        return $groups;
    }

    public function getGroup($groupId)
    {
        return $this->_callApi('group/get/', ['group_id' => $groupId]);
    }

    public function getCompany()
    {
        return $this->_callApi('company/get/');
    }

    private function _callApi(string $method, array $params = [])
    {
        try {
            $response = $this->_httpClient->get($method, ['query' => $params]);
        } catch (ClientException $exception) {
            $data = json_decode($exception->getResponse()->getBody()->getContents());
            switch (intval($data->response->code)) {
                case 404: throw new NotFoundException($data->response->errors->error[0], 404, $exception);
                case 505: throw new InternalServerErrorException($data->response->errors->error[0], 500, $exception);
            }
            throw $exception;
        }
        $data = \json_decode($response->getBody()->getContents());

        return $data->response->data;
    }
}