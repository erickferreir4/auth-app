<?php declare(strict_types=1);

namespace app\traits;

use Google_Client;

/**
 *  Google Trait
 */
trait SocialTrait
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

    /**
     *  Set facebook client
     *
     *  @return object result
     */
    public function facebookClient()
    {
        $facebook = parse_ini_file(__DIR__ . '/../config/facebook.ini');

        $fb = new \Facebook\Facebook([
            'app_id' => $facebook['app_id'],
            'app_secret' => $facebook['app_secret'],
        ]);

        return $fb;
    }

    /**
     *  Get url google
     *
     *  @return string url
     */
    public function facebookUrl() : string
    {
        $helper = $this->facebookClient()->getRedirectLoginHelper();
        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl('http://localhost:8082/login/auth/facebook/callback', $permissions);
        return $loginUrl;
    }

}
