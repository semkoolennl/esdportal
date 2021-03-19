<?php


namespace App\Eset\Application\Handler;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AbstractFormRequestHandler
{
    private $em;

    public function handle($request, $em, $form)
    {
        if ($request->getMethod() == "GET"){
            $formData = $this->getFormData($form);
            $content = ["result" => true, "message" => "Form retrieved", "data" => $formData];
            $statusCode = Response::HTTP_OK;
        } else {
            $this->em = $em;
            $data = json_decode($request->getContent(), true);
            $product = $this->submitForm($form, $data);

            if ($product) {
                return $product;
            }

            $content = ["result" => false, "message" => "Form is invalid.", "data" => null];
            $statusCode = Response::HTTP_BAD_REQUEST;
        }

        return new JsonResponse($content, $statusCode);
    }


    private function getFormData($form)
    {
        $fields = [];
        foreach ($form->all() as $field){
            $fields[$field->getName()] = $field->getData();
        }
        return $fields;
    }

    private function submitForm($form, $data)
    {
        $form->submit($data);

        if ($form->isValid()) {
            $entity = $form->getData();

            $this->em->persist($entity);
            $this->em->flush();

            return $entity;
        } else {
            return false;
        }
    }
}