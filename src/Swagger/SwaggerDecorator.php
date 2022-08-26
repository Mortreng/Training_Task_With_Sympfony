<?php

namespace App\Swagger;


use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model;

final class SwaggerDecorator implements OpenApiFactoryInterface
{
    private OpenApiFactoryInterface $decorated;

    public function __construct(OpenApiFactoryInterface $decorated) {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);
        $pathItem = $openApi->getPaths()->getPath('/api/card/gather_card_data/{pan}');
        $operation = $pathItem->getPost();

        $openApi->getPaths()->addPath('/api/card/gather_card_data/{pan}', $pathItem->withPost(
            $operation->withParameters(array_merge(
                $operation->getParameters(),
                [new Model\Parameter(name:'pan', in:'path', description: 'Fields to remove of the output', required: true)]
            ))
        ));

        $openApi = $openApi->withInfo((new Model\Info('Gather Card Data', 'v2', 'Gathering and verification of the pan entered'))->withExtensionProperty('info-key', 'Info value'));


        return $openApi;
    }
}