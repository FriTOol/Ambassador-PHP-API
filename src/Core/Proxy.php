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
use AmbassadorApi\Exception\NotFoundException;
use AmbassadorApi\Exception\RequiredParamException;
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
        return $this->_getApi('ambassador/all/', $params);
    }

    public function getAmbassador(array $params)
    {
        return $this->_getApi('ambassador/stats/', $params);
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

    public function updateAmbassador(array $data)
    {
        if (!isset($data['email']) && empty($data['email']) &&
            !isset($data['uid']) && empty($data['uid'])
        ) {
            throw new RequiredParamException('Email or uid is required.');
        }

        $this->_postApi('ambassador/update/', $data);
    }

    public function getGroups()
    {
        return $this->_getApi('group/all/');
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
        return $this->_getApi('group/get/', ['group_id' => $groupId]);
    }

    public function getCompany()
    {
        return $this->_getApi('company/get/');
    }

    public function getCommissions(array $params = [])
    {
        return $this->_getApi('commission/all/', $params);
    }

    private function _getApi(string $url, array $query = [])
    {
        return $this->_callApi('get', $url, ['query' => $query]);
    }

    private function _postApi(string $url, array $formParam = [])
    {
        return $this->_callApi('post', $url, ['form_params' => $formParam]);
    }

    private function _callApi(string $method, string $url, array $params = [])
    {
        try {
            $response = $this->_httpClient->request($method, $url, $params);
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