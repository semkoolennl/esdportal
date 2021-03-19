<?php


namespace App\Eset\Application\Parser;


class OrderParser
{
    public function getRequest($request, $price)
    {
        $requestBody = $request->toArray();
        $orderRequest = [
            "TestOrder" => $requestBody['test_order'],
            "CustomerName" => $requestBody['customer_name'],
            "CustomerEmail" => $requestBody["customer_email"],
            "CustomerCompany" => $requestBody["customer_company"] ?? null,
            "LicenseLetterCC" => $requestBody['license_letter_cc'] ?? null,
            "OrderReference" => $requestBody['order_reference'] ?? null,
            "OrderItems" => [
                [
                    "ProductCode" => $price->productCode,
                    "Quantity" => $requestBody['quantity'],
                    "LicenseKey" => $requestBody['license_key'],
                    "LicenceId" => $requestBody['license_id'],
                ]
            ]
        ];

        return $orderRequest;
    }
}