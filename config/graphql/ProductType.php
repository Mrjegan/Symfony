<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Overblog\GraphQLBundle\Annotation as GraphQL;

class ProductType
{
    /**
     * @GraphQL\Field(type="ID!")
     */
    public $id;

    /**
     * @GraphQL\Field(type="String!")
     */
    public $name;

    /**
     * @GraphQL\Field(type="String!")
     */
    public $description;

    /**
     * @GraphQL\Field(type="Float!")
     */
    public $price;
}
