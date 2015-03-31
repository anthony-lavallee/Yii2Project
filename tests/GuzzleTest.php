<?php

//require "../vendor/"
include("../vendor/autoload.php");

use GuzzleHttp\Client;

class GuzzleTest extends PHPUnit_Framework_TestCase
{
    private $apiURL = 'http://kilobeat.com/';

    public function testConnectionCountryIndex()
    {
        $client = new Client();
        $response = $client->get('http://kilobeat.com/country/index');
        $code = $response->getStatusCode();

        $this->assertTrue($code === 200);
    }

    /**
     * @depends testConnectionCountryIndex
     */
    public function testConnectionSiteAbout()
    {
         $this->client = new GuzzleHttp\Client(['base_url' => $this->apiURL], array());
         $response = $this->client->get('site/about');
         $code = $response->getStatusCode();
         $this->assertTrue($code === 200);
    }

     /**
     * @depends testConnectionCountryIndex
     */
    public function testCreateCountry() //Create country
    {
         $data = array(
                'code' => 'TU',
                'name' => 'Test',
                'population' => 1000,
            );

         $headers = [
        'User-Agent' => 'testing/1.0',
        'Accept'     => 'application/json',
        'Content-Type' => 'application/json',
    ];

         $this->client = new GuzzleHttp\Client(['base_url' => $this->apiURL], array());
         $response = $this->client->post('country',  ['body' => json_encode($data), 'headers' => $headers]);
         //echo $response;
         $jsonResponse = json_encode($response->json());
         //echo $jsonResponse;

         //$this->assertContains('"success":"true"', $jsonResponse);
         $this->assertEquals(201, $response->getStatusCode());
    }

    /**
     * @depends testConnectionCountryIndex
     */
    public function testDeleteCountry() //Delete country
    {
        $this->client = new GuzzleHttp\Client(['base_url' => $this->apiURL], array());
        $response = $this->client->delete('/country/delete?id=TU');

        $this->assertEquals(204, $response->getStatusCode());

        /*$this->client = new GuzzleHttp\Client(['base_url' => $this->apiURL], array());
        $response = $this->client->delete('/country',  ['exceptions' => false]);

        $this->assertEquals(405, $response->getStatusCode());*/
    }

     /**
     * @depends testConnectionCountryIndex
     */
    public function testUpdateCountry() //Update country
    {
         $data = array(
                'code' => 'AU',
                'name' => 'Australia',
                'population' => 1000,
            );

         $headers = [
        'User-Agent' => 'testing/1.0',
        'Accept'     => 'application/json',
        'Content-Type' => 'application/json',
    ];


        $this->client = new GuzzleHttp\Client(['base_url' => $this->apiURL], array());
        $response = $this->client->put('/country/update?id=AU', ['body' => json_encode($data), 'headers' => $headers]);
        //echo $response;
        $jsonResponse = json_encode($response->json());
        //echo $jsonResponse;

        //$this->assertContains('"success":"true"', $jsonResponse);
        $this->assertEquals(200, $response->getStatusCode());

    }

    /**
     * @depends testConnectionCountryIndex
     */
    public function testGetCountryWithValidID() //Get_Country_With_Valid_ID
    {
         $this->client = new GuzzleHttp\Client(['base_url' => $this->apiURL], array());
         $response = $this->client->get('country/view?id=AU');
         $code = $response->getStatusCode();
         $this->assertTrue($code === 200);
    }

    /**
     * @depends testConnectionCountryIndex
     */
    public function testGetCountryWithInvalidID() //Get_Country_With_Invalid_ID
    {
         $this->client = new GuzzleHttp\Client(['base_url' => $this->apiURL], array());
         $response = $this->client->get('country/view?id=UM',  ['exceptions' => false]);
         $code = $response->getStatusCode();
         $this->assertTrue($code === 404);
    }
}
?>