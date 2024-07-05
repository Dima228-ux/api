<?php


use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * Class ApiTest
 */
class ApiTest extends TestCase
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetGroup()
    {
        $client = new Client(['base_uri' => 'http://api/group']);
        $data = ['id_user' => 1, 'id_group' => 2];
        $response = $client->get('http://api/group/getGroups');

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('status', $data);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetUserGroup()
    {
        $client = new Client(['base_uri' => 'http://api/group']);
        $response = $client->get('http://api/group/getUser?id=1');
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('status', $data);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testInsertUser()
    {
        $client = new Client(['base_uri' => 'http://api/group']);
        try {
            $response = $client->post(
                'http://api/group/insertUser',
                [
                    'json' => [
                        'id_user' => 1,
                        'id_group' => 4,
                    ]
                ]
            );
            $this->assertEquals(200, $response->getStatusCode());
            $data = json_decode($response->getBody(), true);
            $this->assertArrayHasKey('status', $data);
        } catch (GuzzleHttp\Exception\RequestException $e) {
            $this->assertEquals(400, $e->getResponse()->getStatusCode());
            $data = json_decode($e->getResponse()->getBody(), true);
            $this->assertArrayHasKey('status', $data);
        }
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteUserGroup()
    {
        $client = new Client(['base_uri' => 'http://api/group']);
        $response = $client->delete('http://api/group/deleteUser?id_user=1&id_group=4');
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('status', $data);
    }
}
