<?php


namespace App\DTO\Response\Transformer;


interface ResponseDtoTransformerInterface
{

    public function transformFromObject($object);

    public function transformFromObjects(iterable $objects): iterable;
}