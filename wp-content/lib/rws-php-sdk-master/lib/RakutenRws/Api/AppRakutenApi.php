<?php

/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

/**
 * API for app.rakuten.co.jp
 *
 * @package RakutenRws
 * @subpackage Api
 */
abstract class RakutenRws_Api_AppRakutenApi extends RakutenRws_Api_Base
{
    const BASE_URL = 'https://app.rakuten.co.jp/services/api';

    protected
        $isRequiredAccessToken = true;

    abstract public function getService();
    abstract public function getOperation();

    protected function genUrl()
    {
        $url  = self::BASE_URL;
        $url .= '/'.$this->getService().'/'.$this->getOperation().'/'.$this->getVersion();

        return $url;
    }

    public function getMethod()
    {
        return 'GET';
    }

    public function execute($parameter)
    {
        $url = $this->genUrl();

        if ($this->isRequiredAccessToken) {
            $parameter['access_token'] = $this->client->getAccessToken();
        } else {
            $parameter['applicationId'] = $this->client->getApplicationId();
        }

        if ($this->client->getAffiliateId()) {
            $parameter['affiliateId'] = $this->client->getAffiliateId();
        }

        unset($parameter['callback']);
        unset($parameter['format']);

        $client = $this->client->getHttpClient();
        $method = 'get';
        if (strtoupper($this->getMethod()) !== 'GET') {
            $method = 'post';
        }

        $response = $client->$method($url, $parameter);

        return new RakutenRws_ApiResponse_AppRakutenResponse($this->getOperationName(), $response);
    }
}
