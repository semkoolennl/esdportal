<?php


namespace App\Eset\Application\Parser;


class PriceParser
{
    public function getRequest($request)
    {
        $requestBody = $request->toArray();
        $data = [
            "LicenseKey" => $requestBody['license_id'] ?? null,
            "LicenseId" => $requestBody['license_key'] ?? null,
            "NewProductCode" => $requestBody['product_code'],
            "NewQuantity" => $requestBody['quantity'],
            "Period" => $requestBody['period'],
            "DicountCode" => $requestBody['discount_code'] ?? null,
        ];

        return array_filter($data);
    }

    public function getData($response)
    {
        return get_object_vars($response);
    }
}