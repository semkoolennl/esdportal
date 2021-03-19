<?php


namespace App\Eset\Application\Handler;


use App\Eset\Domain\Entity\Credentials;
use App\Eset\Domain\Entity\Order;
use App\Eset\Application\Parser\OrderParser;
use App\Eset\Application\Parser\PaymentParser;
use App\Eset\Application\Parser\PriceParser;
use App\Eset\Infrastructure\Repository\CompanyDetailsRepository;
use App\Eset\Infrastructure\Repository\OrderRepository;
use Doctrine\ORM\EntityManager;
use Eset\Api\EsetApiClient;
use Mollie\Api\MollieApiClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

class OrderRequestHandler extends AbstractClientRequestHandler
{
    private $orderRepository;
    private $company;
    private $em;
    private $priceParser;
    private $orderParser;
    private $paymentParser;


    public function __construct(
        OrderRepository   $orderRepository,
        CompanyDetailsRepository $companyRepository,
        EsetApiClient     $esetClient,
        MollieApiClient   $mollieClient,
        EntityManager     $em,
        Serializer        $serializer,
        PriceParser       $priceParser,
        OrderParser       $orderParser,
        PaymentParser     $paymentParser
    )
    {
        parent::__construct($companyRepository, $esetClient, $mollieClient, $serializer);
        $this->orderRepository = $orderRepository;
        $this->mollieClient    = $mollieClient;
        $this->em              = $em;
        $this->priceParser     = $priceParser;
        $this->orderParser     = $orderParser;
        $this->paymentParser   = $paymentParser;
    }

    public function create($request, $company = null): JsonResponse
    {
        try {
            if (is_null($company)) {
                $company = $this->getCompany($request);
            }
            $this->setClientCredentials($company);
            $price = $this->getPrice($request);
            $payment  = $this->createPayment($company, $request, $price);

            $data = ["checkout_url" => $payment->getCheckoutUrl()];
            $content    = ["result" => true, "message" => "Payment created.", "data" => $data];
            $statusCode = Response::HTTP_FOUND;
        } catch (\Exception $e) {

            $content    = ["result" => false, "message" => $e->getMessage(), "data" => null];
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return new JsonResponse($content, $statusCode);
    }

    public function update($request, $order = null): JsonResponse
    {
        try {
            if (is_null($order)) {
                $order = $this->orderRepository->findOneBy(["mollieId" => $request->get("id")]);
            }
            $company = $this->getCompanyFromOrder($order);
            $this->setClientCredentials($company);
            $this->mollieClient->setApiKey($company->getMollieKey());

            $payment = $this->mollieClient->payments->get($order->getMollieId());
            $orderRequest = get_object_vars($payment->metadata);
            $this->updateOrderInDatabase($order, "updated", $orderRequest);
        } catch (\Exception $e) {
            return new JsonResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(null, Response::HTTP_OK);
    }


    private function getCompanyFromOrder($order)
    {
        $company = $order->getCompany();
        if (is_null($company)) {
            throw new \Exception("No company found associated with the order.");
        }
        return $company;
    }


    private function getPrice($request)
    {
        $priceRequest = $this->priceParser->getRequest($request);

        return $this->esetClient->price->get($priceRequest);
    }


    private function createPayment($request, $comapny, $price)
    {
        $orderRequest   = $this->orderParser->getRequest($request, $price);
        $paymentRequest = $this->paymentParser->getRequest($request, $price, $orderRequest);

        $payment = $this->mollieClient->payments->create($paymentRequest);
        $this->createOrderInDatabase($comapny, $payment->id, $orderRequest["TestOrder"]);

        return $payment;
    }


    private function createOrderInDatabase($company, $paymentId, $testOrder)
    {
        $order = new Order();
        $order->setCompany($company);
        $order->setMollieId($paymentId);

        if ($testOrder) {
            $order->setType("test_eset");
        } else {
            $order->setType("eset");
        }

        $order->setStatus("awaiting payment");

        $this->em->persist($order);
        $this->em->flush();
    }

    public function updateOrderInDatabase($order, $status, $data)
    {
        $order->setStatus($status);
        $order->setData($data);
        $this->em->flush();
    }
}