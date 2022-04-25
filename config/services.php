<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
	
	'authorize' => [
		'environment' => env('AUTHORIZE_PAYMENT_ENV'),
		'login' => env('AUTHORIZE_PAYMENT_API_LOGIN_ID'),
		'key' => env('AUTHORIZE_PAYMENT_TRANSACTION_KEY')
	],
	
	'twilio' => [
		'sid' => env('TWILIO_SID'),
		'token' => env('TWILIO_AUTH_TOKEN'),
		'number' => env('TWILIO_NUMBER')
	],
	
	'google' => [
		'api' => env('GOOGLE_API'),
		'address' => env('STORE_ADDRESS'),
	]

];
