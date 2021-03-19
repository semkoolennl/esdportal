<?php


namespace App\Tests\Eset\Endpoints;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class getPriceEndpointTest extends WebTestCase
{
    /** @test */
    public function itRetrievesTheExtendPriceOfALicense()
    {
        $client = static::createClient();
        $data = json_encode([
            "license_id" => "3AB-AP8-2N9",
            "license_key" => "AWNV-XCCH-4K46-PFSM-64VW",
            "product_code" => "106",
            "quantity" => "1",
            "period" => "1",
            "discount_code" => "7",
        ]);

        $client->request(
            "POST",
            "api/eset/price",
            [],
            [],
            [
                "HTTP_X_API_TOKEN" => "api_token_test",
            ],
            $data
        );

        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(true, $content['result']);
        $this->assertArrayHasKey('Price', $content['data']);
        $this->assertArrayHasKey('DiscountPrice', $content['data']);
        $this->assertArrayHasKey('ProductCode', $content['data']);
    }
}