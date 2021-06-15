<?php

namespace glasswalllab\keypayconnector;

use glasswalllab\keypayconnector\Jobs\CallWebService;
use glasswalllab\keypayconnector\TokenStore\TokenCache;
use Illuminate\Http\Request;

class KeypayConnector 
{
    public function CallWebServiceSync($endpoint,$method,$body)
    {  
        //Could move the below to job - but was having issues with the return
        $tokenCache = new TokenCache();
        $accessToken = $tokenCache->getAccessToken(config('keypayConnector.provider'));

        $url = config('keypayConnector.baseUrl').config('keypayConnector.tenantId')."/Production/ODataV4/Company('".config('keypayConnector.companyName')."')".$endpoint;

        $options['headers']['Content-Type'] = 'application/json';
        $options['headers']['If-Match'] = '*';

        $options['body'] = $body; //json encoded value

        $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientSecret'            => config('keypayConnector.appSecret'),
            'redirectUri'             => config('keypayConnector.redirectUri'),
            'urlAuthorize'            => config('keypayConnector.authority').config('keypayConnector.authoriseEndpoint'),
            'client_id'               => config('keypayConnector.appId'),
            'urlAccessToken'          => config('keypayConnector.authority').config('keypayConnector.tokenEndpoint'),
            'urlResourceOwnerDetails' => config('keypayConnector.resource'),
          ]);

        try
        {
            $request = $this->oauthClient->getAuthenticatedRequest(
                $method,
                $url,
                $accessToken,
                $options,
            );

            $response = $this->oauthClient->getResponse($request);
            return $response->getBody()->getContents();
            //event(new ResponseReceived($oauthClient->getResponse($request)));
            
        } catch (Exception $ex) {
            return($ex);
        }
    }

    public function CallWebServiceQueue($endpoint,$method,$body)
    {  
        $call = CallWebService::dispatch($endpoint,$method,$body);
    }
}
