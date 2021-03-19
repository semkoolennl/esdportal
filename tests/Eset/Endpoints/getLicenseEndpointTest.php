<?php


namespace App\Tests\Eset\Endpoints;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class getLicenseEndpointTest extends WebTestCase
{
    /** @test */
    public function itFindsAndReturnsLicenseWithA302StatusCode()
    {
        $client = static::createClient();

        $data = json_encode([
            "license_id" => "3AB-AP8-2N9",
            "license_key" => "AWNV-XCCH-4K46-PFSM-64VW"
        ]);

        $client->request(
            "POST",
            "api/services/eset/licenses/get",
            [],
            [],
            [
                "HTTP_X_API_TOKEN" => "api_token_test",
            ],
            $data
        );

        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(true, $content['result']);
        $this->assertIsArray($content['data']);
    }

    /** @test */
    public function invalidLicenseIdTest()
    {
        $client = static::createClient();

        $data = json_encode([
            "license_id" => "2AB-AP8-2N9",
            "license_key" => "AWNV-XCCH-4K46-PFSM-64VW"
        ]);

        $client->request(
            "POST",
            "api/services/eset/licenses/get",
            [],
            [],
            [
                "HTTP_X_API_TOKEN" => "api_token_test",
            ],
            $data
        );

        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(false, $content['result']);
        $this->assertNull(null, $content['result']);
    }
}