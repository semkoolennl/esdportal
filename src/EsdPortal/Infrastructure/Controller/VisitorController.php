<?php


namespace App\EsdPortal\Infrastructure\Controller;


use App\EsdPortal\Infrastructure\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class VisitorController extends AbstractController
{
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }


    /**
     * @Route("{path}", requirements={"path"=".+"}, methods={"GET", "POST"})
     */
    public function index(Request $request, $path = "/")
    {
        return $this->render('esdPortal.html.twig');
    }

    /**
     * @Route("/domains/{subdomain}", priority=1, methods={"GET", "POST"})
     */
    public function companyIndex(Request $request, $subdomain)
    {
        $company = $this->companyRepository->findOneBy(['subdomain' => $subdomain]);
        if($company){
            return $this->render('Client.html.twig', ['api_token' => $company->getApiToken()]);
        }
        return new JsonResponse($subdomain, 200);
    }

    /**
     * @Route("/api/{path}", requirements={"path"=".+"}, priority=1, methods={"GET", "POST"})
     */
    public function api404(Request $request, $path = "/")
    {
        $content = ["result" => false, "message" => "Invalid API endpoint.", "data" => null];
        return new JsonResponse($content, Response::HTTP_FOUND);
    }
}