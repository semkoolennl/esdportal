<?php


namespace App\Eset\Infrastructure\Controller;


use App\Eset\Application\Handler\OrderRequestHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/webhooks/eset", priority=2)
 */
class WebhookController extends AbstractController
{
    /**
     * @Route("/orders/update", methods={"POST"}, name="confirmEsetOrderWebhook")
     * @param Request $request
     * @param OrderRequestHandler $handler
     * @return JsonResponse
     */
    public function updateOrder(Request $request, OrderRequestHandler $handler): JsonResponse
    {
        return $handler->update($request);
    }
}