<?php


namespace App\Eset\Infrastructure\Controller\Admin;



use App\Eset\Domain\Entity\Product;
use App\Eset\Application\Handler\AbstractFormRequestHandler;
use App\Eset\Infrastructure\Repository\ProductRepository;
use App\Form\EsetProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route("/api/admin/eset")
 */
class ProductController extends AbstractController
{
    private $esetEntityManager;
    private $productRepository;
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    private function setProductRepository()
    {
        $this->esetEntityManager = $this->getDoctrine()->getManager('eset');
        $this->productRepository = $this->esetEntityManager->getRepository(Product::class);
    }

    /**
     * @Route("/products", methods={"GET"}, name="listEsetProducts")
     * @return JsonResponse
     */
    public function listProducts(Request $request)
    {
        $this->setProductRepository();
        $filters = $request->query->all();
        $products = $this->productRepository->filterByArray($filters);
        $productCollection = [];
        if ($products) {
            foreach ($products as $product) {
                $json = $this->serializer->serialize($product, 'json');
                $productCollection[] = json_decode($json, true);
            }
        }

        $content = ["result" => true, "message" => null, "data" => $productCollection];
        return new JsonResponse($content, 200);
    }

    /**
     * @Route("/products/create", methods={"GET", "POST"})
     * @param Request $request
     * @param AbstractFormRequestHandler $handler
     * @return JsonResponse|Response
     */
    public function createProduct(Request $request, AbstractFormRequestHandler $handler)
    {
        $this->setProductRepository();
        $product = new Product();
        return $this->productFormHandler($handler, $request, $product);
    }

    /**
     * @Route("/products/{id}", methods={"GET"}, name="getEsetProduct")
     * @param int $id
     * @return JsonResponse
     */
    public function getProduct(int $id)
    {
        $this->setProductRepository();
        $product = $this->productRepository->find($id);
        if ($product){
            $json = $this->serializer->serialize($product, 'json');
            $content = ["result" => true, "message" => null, "data" => json_decode($json, true)];
            $statusCode = Response::HTTP_FOUND;
        } else {
            $content = ["result" => false, "message" => "Product not found.", "data" => null];
            $statusCode = Response::HTTP_NOT_FOUND;
        }
        return new JsonResponse($content, $statusCode);
    }


    /**
     * @Route("/products/{id}/edit", methods={"GET"," POST"})
     * @param Request $request
     * @param AbstractFormRequestHandler $handler
     * @param int $id
     * @return JsonResponse|Response
     */
    public function editProduct(Request $request, AbstractFormRequestHandler $handler, int $id)
    {
        $this->setProductRepository();
        $product = $this->productRepository->find($id);

        if ($product){
            return $this->productFormHandler($handler, $request, $product);
        } else {
            $content = ["result" => false, "message" => "Product not found.", "data" => null];
            $statusCode = Response::HTTP_NOT_FOUND;
        }

        return new JsonResponse($content, $statusCode);
    }


    private function productFormHandler($formHandler, $request, $product)
    {
        $form = $this->createForm(EsetProductType::class, $product, ['csrf_protection' => false]);

        $response =  $formHandler->handle($request, $this->esetEntityManager, $form);
        if (get_class($response) == Product::class){
            $response = $this->forward('App\Eset\Infrastructure\Controller\AdminController::getProduct',
                ["id" => $response->getId()]
            );
        }

        return $response;
    }




}