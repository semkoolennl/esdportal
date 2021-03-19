<?php


namespace App\EsdPortal\Infrastructure\Controller;



use App\EsdPortal\Domain\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/public", priority=2)
 */
class PublicController extends AbstractController
{
    private $serializer;
    private $em;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $this->serializer = $serializer;
        $this->em = $em;
    }


    /**
     * @Route("/customers", methods={"GET"})
     */
    public function listCustomers()
    {
        $companyRepository = $this->em->getRepository(Company::class);
        $companies = $companyRepository->findAll();
        $collection = [];
        foreach ($companies as $company)
        {
            $serialized = $this->serializer->serialize($company, 'json');
            $collection[] = json_decode($serialized, true);
        }

        $content = ["result" => true, "message" => "Customers retrieved.", "data" => $collection];
        return new JsonResponse($content, Response::HTTP_OK);
    }
}