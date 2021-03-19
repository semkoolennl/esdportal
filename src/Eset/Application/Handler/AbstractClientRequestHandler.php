<?php


namespace App\Eset\Application\Handler;


use Mollie\Api\MollieApiClient;

abstract class AbstractClientRequestHandler
{
    protected $companyRepository;
    protected $esetClient;
    protected $mollieClient;
    protected $serializer;

    public function __construct($companyRepository, $esetClient, $mollieClient, $serializer)
    {
        $this->companyRepository = $companyRepository;
        $this->esetClient        = $esetClient;
        $this->mollieClient      = $mollieClient;
        $this->serializer        = $serializer;
    }

    protected function getCompany($request)
    {
        $apiToken = $request->headers->get("x-api-token");
        if (is_null($apiToken)) {
            throw new \Exception("Missing header: 'x-api-token'.");
        }

        $company = $this->companyRepository->findOneBy(["apiToken" => $apiToken]);
        if (is_null($company)) {
            throw new \Exception("No company found with the given API token.");
        }

        return $company;
    }

    protected function setClientCredentials($company)
    {
        $esetGuid = $company->getEsetGuid();
        $esetKey = $company->getEsetKey();
        $mollieKey = $company->getMollieKey();
        $this->esetClient->setCredentials($esetGuid, $esetKey);
        $this->mollieClient->setApiKey($mollieKey);
    }
}