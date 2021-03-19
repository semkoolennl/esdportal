<?php


namespace App\Eset\Application\Parser;


class PaymentParser
{
    public function getRequest($request, $price, $orderRequest)
    {
        $baseUrl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
        $baseUrl = "http://2d1b7023f0a9.ngrok.io";
        $requestBody = $request->toArray();
        $paymentRequest = [
            "amount" => [
                "currency" => "EUR",
                "value" => (string)$price->Price
            ],
            "description" => $requestBody['description'],
            "redirectUrl" => $requestBody['redirect_url'],
            "webhookUrl" => $baseUrl . "/api/webhooks/eset/orders/update",
            "metadata" => $orderRequest
        ];

        return array_filter($paymentRequest);
    }
}