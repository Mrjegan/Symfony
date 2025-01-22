<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Type\ObjectType;

class ProductType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Product',
            'fields' => [
                'id' => ['type' => Type::id()],
                'name' => ['type' => Type::string()],
                'description' => ['type' => Type::string()],
                'price' => ['type' => Type::float()],
            ]
        ]);
    }
}
