<?php declare(strict_types=1);

namespace app\traits;

use Google_Client;

/**
 *  Google Trait
 */
trait GoogleTrait
{
    /**
     *  Set google client
     *
     *  @return object result
     */
    public function googleClient()
    {
        $variables = parse_ini_file(__DIR__ . '/../config/variables.ini');

        $redirectUri = $variables['host_uri'] . '/login';

        // create Client Request to access Google API
        $client = new Google_Client();
        $client->setAuthConfig(__DIR__ . '/../config/client_google.json');
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");

        return $client;
    }

    /**
     *  Get url google
     *
     *  @return string url
     */
    public function googleUrl() : string
    {
        return $this->googleClient()->createAuthUrl();
    }
}
