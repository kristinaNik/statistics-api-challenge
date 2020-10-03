<?php


namespace App\DTO;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class DataTransferObjectConverter implements ParamConverterInterface
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
       $data = $request->get('content');
       $class = $configuration->getClass();
       $dto =  $this->serializer->denormalize($data, $class);

       if ($request->files->count() > 0) {
           $dto = $this->serializer->denormalize($request->files->all(), $class, [
               'object_to_populate' => $dto
           ]);
       }

       $request->attributes->set($configuration->getName(), $dto);

       return true;
    }

    public function supports(ParamConverter $configuration)
    {
        return true;
    }
}