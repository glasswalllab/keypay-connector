<?php

namespace glasswalllab\keypayconnector\Jobs;

use glasswalllab\keypayconnector\TokenStore\TokenCache;
use glasswalllab\keypayconnector\Events\ResponseReceived;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CallWebService implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $endpoint;
    private $method;
    private $body;
    private $authClient;

    public function __construct($endpoint,$method,$body)
    {
        $this->endpoint = $endpoint;
        $this->method = $method;
        $this->body = $body;
    }

    public function handle()
    {
        $tokenCache = new TokenCache();
        $accessToken = $tokenCache->getAccessToken('keypay');

        $url = config('keypayConnector.baseUrl').config('keypayConnector.tenantId')."/Production/ODataV4/Company('".config('keypayConnector.companyName')."')".$this->endpoint;

        $options['headers']['Content-Type'] = 'application/json';
        $options['headers']['If-Match'] = '*';

        $options['body'] = $this->body; //json encoded value
        
        $this->oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => config('keypayConnector.appId'),
            'clientSecret'            => config('keypayConnector.appSecret'),
            'redirectUri'             => config('keypayConnector.redirectUri'),
            'urlAuthorize'            => config('keypayConnector.authority').config('keypayConnector.tenantId').config('keypayConnector.authoriseEndpoint'),
            'urlAccessToken'          => config('keypayConnector.authority').config('keypayConnector.tenantId').config('keypayConnector.tokenEndpoint'),
            'urlResourceOwnerDetails' => config('keypayConnector.resource'),
            'scopes'                  => config('keypayConnector.scopes'),
        ]);

        try
        {
            $request = $this->oauthClient->getAuthenticatedRequest(
                $this->method,
                $url,
                $accessToken,
                $options,
            );

            $response = $this->oauthClient->getResponse($request);
            return json_decode($response->getBody()->getContents());
            //event(new ResponseReceived($oauthClient->getResponse($request)));
            
        } catch (Exception $ex) {
            return($ex);
        }
    }
}