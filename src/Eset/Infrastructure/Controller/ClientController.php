<?php


namespace App\Eset\Infrastructure\Controller;


use App\Eset\Application\Handler\OrderRequestHandler;
use App\Eset\Application\Handler\LicenseRequestHandler;
use App\Eset\Application\Handler\PriceRequestHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/client/eset", priority=2)
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/licenses/get", methods={"POST"})
     * @param Request $request
     * @param LicenseRequestHandler $handler
     * @return JsonResponse
     */
    public function getLicense(Request $request, LicenseRequestHandler $handler): JsonResponse
    {
        return $handler->get($request);
    }

    /**
     * @Route("/orders/create", methods={"POST"})
     * @param Request $request
     * @param OrderRequestHandler $handler
     * @return JsonResponse
     */
    public function createOrder(Request $request, OrderRequestHandler $handler): JsonResponse
    {
        return $handler->create($request);
    }


    /**
     * @Route("/price", methods={"POST"})
     * @param Request $request
     * @param PriceRequestHandler $handler
     * @return JsonResponse
     */
    public function getPrice(Request $request, PriceRequestHandler $handler): JsonResponse
    {
        return $handler->get($request);
    }

}