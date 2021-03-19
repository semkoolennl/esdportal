<?php


namespace App\Eset\Application\Handler;


use Doctrine\ORM\EntityManagerInterface;

class ProductRequestHandler extends AbstractFormRequestHandler
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function get($request, $id)
    {

    }
}