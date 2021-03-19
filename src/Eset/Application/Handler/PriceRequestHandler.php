<?php


namespace App\Eset\Application\Handler;



use App\Eset\Application\Parser\PriceParser;
use App\Eset\Infrastructure\Repository\CompanyDetailsRepository;
use Eset\Api\EsetApiClient;
use Mollie\Api\MollieApiClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

class PriceRequestHandler extends AbstractClientRequestHandler
{
    private $priceParser;
    public function __construct(
        CredentialsRepository $companyRepository,
        EsetApiClient     $esetClient,
        MollieApiClient   $mollieClient,
        Serializer        $serializer,
        PriceParser       $priceParser
    )
    {
        parent::__construct($companyRepository, $esetClient, $mollieClient, $serializer);
        $this->priceParser = $priceParser;
    }

    public function get($request, $company = null)
    {
        try {
            if (is_null($company)) {
                $company = $this->getCompany($request);
            }
            $this->setClientCredentials($company);
            $priceRequest = $this->priceParser->getRequest($request);
            $priceResponse = $this->esetClient->price->get($priceRequest);
            $priceData = $this->priceParser->getData($priceResponse);
            $content    = ["result" => false, "message" => "Price succesfully retrieved from ESET.", "data" => $priceData];
            $statusCode = Response::HTTP_OK;
        } catch (\Exception $e) {

            $content    = ["result" => false, "message" => $e->getMessage(), "data" => null];
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return new JsonResponse($content, $statusCode);
    }
}