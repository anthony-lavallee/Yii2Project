
<?php

//require "../vendor/"
include("../vendor/autoload.php");

use GuzzleHttp\Client;

class GuzzleTest extends PHPUnit_Framework_TestCase
{
    private $apiURL = 'http://kilobeat.com/';
    
    public function testUserCanGetAnAccessToken()
    {
        $data = array(
                'username' => 'Test',
                'password' => 'Test',
                /*'username' => 'bshaffer',
                'password' => 'brent123',*/
                'first_name' => 'Test',
                'last_name' => 'Test',
                'grant_type' => 'password',
                'client_id' => 'testclient',
                'client_secret' => 'testpass',
                'user_id' => 'bshaffer',
            );

         $headers = [
        'response_type' => 'code',
        'client_id' => 'testclient',
        'redirect_uri' => 'http://fake/',
        'grant_type' => 'authorization_code',
        'User-Agent' => 'testing/1.0',
        'Accept'     => 'application/json',
        'Content-Type' => 'application/json',
    ];

         $this->client = new GuzzleHttp\Client(['base_url' => $this->apiURL], array());

         $response = $this->client->post('oauth2/default/token',  ['body' => json_encode($data), 'headers' => $headers]);
         echo $response;
        /* $pdo = new PDO('mysql:host=localhost;dbname=yii2basic', 'root', 'root');

         $storage = new OAuth2\Storage\Pdo($pdo);

         $storage->setClientDetails('testclient', 'testpass', 'http://fake/', 'password', null, 'bshaffer');
         $storage->setUser('Test', 'Test', 'Test', 'Test');*/

         $jsonResponse = json_encode($response->json());
        // echo $jsonResponse;

         $this->assertContains('access_token', $jsonResponse);
         //$this->assertEquals(200, $response->getStatusCode());
    }

    public function testQueryAuthWithValidParameters()
    {
        $data = array(
                'username' => 'Test',
                'password' => 'Test',
                /*'username' => 'bshaffer',
                'password' => 'brent123',*/
                'first_name' => 'Test',
                'last_name' => 'Test',
                'grant_type' => 'password',
                'client_id' => 'testclient',
                'client_secret' => 'testpass',
                'user_id' => 'bshaffer',
            );

        $headers = [
        'response_type' => 'code',
        'client_id' => 'testclient',
        'redirect_uri' => 'http://fake/',
        'grant_type' => 'authorization_code',
        'User-Agent' => 'testing/1.0',
        'Accept'     => 'application/json',
        'Content-Type' => 'application/json',
    ];


        $this->client = new GuzzleHttp\Client(['base_url' => $this->apiURL], array());

        $response = $this->client->post('oauth2/default/token',  ['body' => json_encode($data), 'headers' => $headers]);
        $jsonResponse = json_encode($response->json());

        $token = substr($jsonResponse,17,40);


        $response = $this->client->get('country/index?accessToken=' .$token);


        $code = $response->getStatusCode();
        $this->assertTrue($code === 200);

    }

    public function testQueryAuthWithInvalidParameters()
    {
         $data = array(
                'username' => 'Test',
                'password' => 'Test',
                /*'username' => 'bshaffer',
                'password' => 'brent123',*/
                'first_name' => 'Test',
                'last_name' => 'Test',
                'grant_type' => 'password',
                'client_id' => 'testclient',
                'client_secret' => 'testpass',
                'user_id' => 'bshaffer',
            );

         $headers = [
        'response_type' => 'code',
        'client_id' => 'testclient',
        'redirect_uri' => 'http://fake/',
        'grant_type' => 'authorization_code',
        'User-Agent' => 'testing/1.0',
        'Accept'     => 'application/json',
        'Content-Type' => 'application/json',
    ];


        $this->client = new GuzzleHttp\Client(['base_url' => $this->apiURL], array());

        $response = $this->client->post('oauth2/default/token',  ['body' => json_encode($data), 'headers' => $headers]);

        $response = $this->client->get('country/index?accessToken=InvalidToken', ['exceptions' => false]);
        $code = $response->getStatusCode();
        $this->assertTrue($code === 401);
    }

    public function testOAuthWithValidParameters()
    {
        $data = array(
                'username' => 'Test',
                'password' => 'Test',
                /*'username' => 'bshaffer',
                'password' => 'brent123',*/
                'first_name' => 'Test',
                'last_name' => 'Test',
                'grant_type' => 'password',
                'client_id' => 'testclient',
                'client_secret' => 'testpass',
                'user_id' => 'bshaffer',
            );

        $headers = [
        'response_type' => 'code',
        'client_id' => 'testclient',
        'redirect_uri' => 'http://fake/',
        'grant_type' => 'authorization_code',
        'User-Agent' => 'testing/1.0',
        'Accept'     => 'application/json',
        'Content-Type' => 'application/json',
    ];


        $client = new Client([
            'base_url' => $this->apiURL,
            'defaults' => [
                'headers' => ['Accept' => 'application/json', 'Authorization' => 'Bearer de175d20c8736cb571cc093d5faa489e3f880c3e']
            ]
        ]);

        $response = $client->get('country/index');

        $this->assertEquals(200, $response->getStatusCode());



        /*$ch = curl_init();
     
        // 2. set the options, including the url
        curl_setopt($ch, CURLOPT_URL, $this->apiURL .'country/index');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, $headers);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . 'f56dba00786b5a17d2b9ed6f4be23bf2bc8b760c'));
     
        // 3. execute and fetch the resulting HTML output
        $output = curl_exec($ch);
        //echo $output;

        $this->assertContains('HTTP/1.1 200 OK', $output);
        curl_close($ch);*/
    }

    public function testOAuthWithInvalidParameters()
    {
        $data = array(
                'username' => 'Test',
                'password' => 'Test',
                /*'username' => 'bshaffer',
                'password' => 'brent123',*/
                'first_name' => 'Test',
                'last_name' => 'Test',
                'grant_type' => 'password',
                'client_id' => 'testclient',
                'client_secret' => 'testpass',
                'user_id' => 'bshaffer',
            );

        $headers = [
        'response_type' => 'code',
        'client_id' => 'testclient',
        'redirect_uri' => 'http://fake/',
        'grant_type' => 'authorization_code',
        'User-Agent' => 'testing/1.0',
        'Accept'     => 'application/json',
        'Content-Type' => 'application/json',
    ];


        $client = new Client([
            'base_url' => $this->apiURL,
            'defaults' => [
                'headers' => ['Accept' => 'application/json', 'Authorization' => 'Bearer InvalidToken']
            ]
        ]);

        $response = $client->get('country/index', ['exceptions' => false]);

        $this->assertEquals(401, $response->getStatusCode());







       /* $ch = curl_init();
     
        // 2. set the options, including the url
        curl_setopt($ch, CURLOPT_URL, $this->apiURL .'country/index');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, $headers);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Authorization: Bearer ' . 'InvalidToken' ));
     
        // 3. execute and fetch the resulting HTML output
        $output = curl_exec($ch);
        //echo $output;

        $this->assertContains('HTTP/1.1 401 Unauthorized', $output);
        curl_close($ch);*/
    }

    public function testBasicAuthWithValidParameters()
    {
         $data = array(
                'username' => 'Test',
                'password' => 'Test',
                /*'username' => 'bshaffer',
                'password' => 'brent123',*/
                'first_name' => 'Test',
                'last_name' => 'Test',
                'grant_type' => 'password',
                'client_id' => 'testclient',
                'client_secret' => 'testpass',
                'user_id' => 'bshaffer',
            );

        $headers = [
        'response_type' => 'code',
        'client_id' => 'testclient',
        'redirect_uri' => 'http://fake/',
        'grant_type' => 'authorization_code',
        'User-Agent' => 'testing/1.0',
        'Accept'     => 'application/json',
        'Content-Type' => 'application/json',
    ];

       $client = new Client([
            'base_url' => $this->apiURL,
            'defaults' => [
                'headers' => ['Accept' => 'application/json'],
                'auth' => ['Test', '640ab2bae07bedc4c163f679a746f7ab7fb5d1fa']
            ]
        ]);

        $response = $client->get('country/index', ['exceptions' => false]);

        //$this->assertEquals(200, $response->getStatusCode());





        /*$ch = curl_init();
     
        // 2. set the options, including the url
        curl_setopt($ch, CURLOPT_URL, $this->apiURL .'country/index');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, $headers);
        // send the username and password
        curl_setopt($ch, CURLOPT_USERPWD, "Test:640ab2bae07bedc4c163f679a746f7ab7fb5d1fa");

        // if you allow redirections
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // this lets cURL keep sending the username and password
        // after being redirected

        curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, 1);

        // 3. execute and fetch the resulting HTML output
        $output = curl_exec($ch);
        //echo $output;

        //$this->assertContains('HTTP/1.1 401 Unauthorized', $output);
        curl_close($ch);*/


    }


   public function testBasicAuthWithInvalidParameters()
    {
         $data = array(
                'username' => 'Test',
                'password' => 'Test',
                /*'username' => 'bshaffer',
                'password' => 'brent123',*/
                'first_name' => 'Test',
                'last_name' => 'Test',
                'grant_type' => 'password',
                'client_id' => 'testclient',
                'client_secret' => 'testpass',
                'user_id' => 'bshaffer',
            );

        $headers = [
        'response_type' => 'code',
        'client_id' => 'testclient',
        'redirect_uri' => 'http://fake/',
        'grant_type' => 'authorization_code',
        'User-Agent' => 'testing/1.0',
        'Accept'     => 'application/json',
        'Content-Type' => 'application/json',
    ];


    $client = new Client([
            'base_url' => $this->apiURL,
            'defaults' => [
                'headers' => ['Accept' => 'application/json'],
                'auth' => ['Test', 'InvalidPassword']
            ]
        ]);

        $response = $client->get('country/index', ['exceptions' => false]);

        $this->assertEquals(401, $response->getStatusCode());



/*
        $ch = curl_init();
     
        // 2. set the options, including the url
        curl_setopt($ch, CURLOPT_URL, $this->apiURL .'country/index');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, $headers);
        // send the username and password
        curl_setopt($ch, CURLOPT_USERPWD, "Test:InvalidPassword");

        // if you allow redirections
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // this lets cURL keep sending the username and password
        // after being redirected

        curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, 1);

        // 3. execute and fetch the resulting HTML output
        $output = curl_exec($ch);

        $this->assertContains('HTTP/1.1 401 Unauthorized', $output);
        curl_close($ch);*/


    }



}
?>