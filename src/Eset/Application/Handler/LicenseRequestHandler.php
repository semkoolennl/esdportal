<?php


namespace App\Eset\Application\Handler;


use App\Eset\Infrastructure\Repository\CompanyDetailsRepository;
use Eset\Api\EsetApiClient;
use Mollie\Api\MollieApiClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

class LicenseRequestHandler extends AbstractClientRequestHandler
{
    public function __construct(
        CompanyDetailsRepository $companyRepository,
        EsetApiClient     $esetClient,
        MollieApiClient   $mollieClient,
        Serializer        $serializer
    )
    {
        parent::__construct($companyRepository, $esetClient, $mollieClient, $serializer);
    }


    public function get(Request $request)
    {
        try {
            $company = $this->getCompany($request);
            $this->setClientCredentials($company);

            $requestBody = $request->toArray();
            $licenseId = $requestBody['license_id'];
            $licenseKey = $requestBody['license_key'];

            $license = $this->esetClient->license->get($licenseId, $licenseKey);
            $data = get_object_vars($license);

            $content = ["result" => true, "message" => "License retrieved", "data" => $data];
            $statusCode = Response::HTTP_FOUND;
        } catch (\Exception $e){
            $content = ["result" => false, "message" => $e->getMessage(), "data" => null];
            $statusCode = Response::HTTP_NOT_FOUND;
        }

        return new JsonResponse($content, $statusCode);
    }
}