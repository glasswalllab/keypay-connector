<?php

namespace glasswalllab\keypayconnector\TokenStore;

use glasswalllab\keypayconnector\Models\Token;
use Carbon\Carbon;

class TokenCache {

  public function storeTokens($accessToken) {
   
    $token = Token::updateOrCreate(['provider' => config('keypayConnector.provider')],
        [
            'accessToken' => $accessToken->getToken(),
            'refreshToken' => $accessToken->getRefreshToken(),
            'tokenExpires' => Carbon::createFromTimestamp($accessToken->getExpires())->toDateTimeString(),
        ]);
    $token->save();
  }

  public function clearTokens($provider) {
    $tokens = Token::where('provider',$provider)->get();
    foreach($tokens as $token)
    {
        Token::destroy($token->id);
    }
  }

  public function getAccessToken($provider) {

    $token = Token::firstWhere('provider',$provider);
    
    // Check if tokens exist
    if (empty($token)) {
      return '';
    }
  
    // Check if token is expired
    //Get current time + 5 minutes (to allow for time differences)
    $now = time() + 300;
    if (strtotime($token->tokenExpires) <= $now) {
        // Token is expired (or very close to it)
        // so let's refresh
  
        // Initialize the OAuth client
        // Initialize the OAuth client
        $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => config('keypayConnector.appId'),
            'clientSecret'            => config('keypayConnector.appSecret'),
            'redirectUri'             => config('keypayConnector.redirectUri'),
            'urlAuthorize'            => config('keypayConnector.authority').config('keypayConnector.tenantId').config('keypayConnector.authoriseEndpoint'),
            'urlAccessToken'          => config('keypayConnector.authority').config('keypayConnector.tenantId').config('keypayConnector.tokenEndpoint'),
            'urlResourceOwnerDetails' => config('keypayConnector.resource'),
            'scopes'                  => config('keypayConnector.scopes'),
        ]);
  
        try {
        $newToken = $oauthClient->getAccessToken('refresh_token', [
            'refresh_token' => $token->refreshToken
        ]);

        // Store the new values
        $this->updateTokens($token->id,$newToken);

        return $newToken->getToken();

        }
        catch (League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            return '';
        }
    }
  
    // Token is still valid, just return it
    return $token->accessToken;
  }

  public function updateTokens($id,$accessToken) {

    Token::where('id',$id)
        ->update([
            'accessToken' => $accessToken->getToken(),
            'refreshToken' => $accessToken->getRefreshToken(),
            'tokenExpires' => Carbon::createFromTimestamp($accessToken->getExpires())->toDateTimeString(),
            
        ]);
  }
}