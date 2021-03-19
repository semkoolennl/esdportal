<?php


namespace App\IAmAlive\Infrastructure\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class IAmAliveController extends AbstractController
{
    /**
     * @Route("/i-am-alive", methods={"GET"})
     */
    public function handle()
    {
        return new JsonResponse(true, 200);
    }
}