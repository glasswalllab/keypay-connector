<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'provider'          => env('KEYPAY_PROVIDER', 'keypay'),
    'tenantId'          => env('KEYPAY_TENANT_ID', ''),
    'appId'             => env('KEYPAY_APP_ID', ''),
    'appSecret'         => env('KEYPAY_APP_SECRET', ''),
    'redirectUri'       => env('KEYPAY_REDIRECT_URI', ''),
    'authority'         => env('KEYPAY_AUTHORITY', ''),
    'authoriseEndpoint' => env('KEYPAY_AUTHORISE_ENDPOINT', '/oauth2/authorize'),
    'tokenEndpoint'     => env('KEYPAY_TOKEN_ENDPOINT', '/oauth2/token'),
    'resource'          => env('KEYPAY_RESOURCE', ''),
    'scopes'            => env('KEYPAY_SCOPES',''),
    'baseUrl'           => env('KEYPAY_BASE_API_URL',''),
    'companyName'       => env('KEYPAY_COMPANY_NAME',''),
    'businessId'        => env('KEYPAY_BUSINESS_ID',''),
];