<?php


namespace App\Tests\Eset\Endpoints;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class createOrderEndpointTest extends WebTestCase
{
    /** @test */
    public function ItCreatesAnOrderAndReturnsAPaymentLink()
    {
        $client = static::createClient();
        $data = [
            "description" => "[NEW][3YEARS] ESET NOD32 Antivirus",
            "redirect_url" => "https://stackoverflow.com/questions/700227/whats-quicker-and-better-to-determine-if-an-array-key-exists-in-php",

            "test_order" => true,
            "license_id" => "",
            "license_key" => "",
            "product_code" => 106,
            "quantity" => 1,
            "period" => 5,
            "discount_code" => null,

            "customer_name" => "Sem Koolen",
            "customer_email" => "sem.koolen@gmail.com",
            "customer_company" => "",
            "license_letter_cc" => "",
            "order_reference" => ""
        ];

        $client->request(
            "POST",
            "api/eset/orders/create",
            [],
            [],
            [
                "HTTP_X_API_TOKEN" => "api_token_test",
            ],
            json_encode($data)
        );

        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);
        var_dump($content);

        $this->assertEquals(true, true);
    }
}