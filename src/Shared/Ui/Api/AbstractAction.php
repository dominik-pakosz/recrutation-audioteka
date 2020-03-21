<?php

namespace App\Shared\Ui\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractAction extends AbstractController
{
    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    private $validator;

    protected function getDeserializedData(string $fqcn, Request $request): object
    {
        if (empty($request->getContent())) {
            throw new BadRequestHttpException('Empty body');
        }

        try {
            $deserializedData = $this->serializer->deserialize(
                $request->getContent(),
                $fqcn,
                'json'
            );
        } catch (\Exception $exception) {
            throw new BadRequestHttpException('Invalid body');
        }

        $violations = $this->validator->validate($deserializedData);

        if ($violations->count() > 0) {
            throw new BadRequestHttpException($this->serializer->serialize($violations, 'json'));
        }

        return $deserializedData;
    }

    /**
     * @required
     */
    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }

    /**
     * @required
     */
    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }
}