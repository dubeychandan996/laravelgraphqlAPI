<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CreateProductMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createProduct',
    ];

    public function type(): Type
    {
        return GraphQL::type('Product');
    }

    public function args(): array
    {
        return [
            'name' => ['type' => Type::nonNull(Type::string())],
            'description' => ['type' => Type::string()],
            'price' => ['type' => Type::nonNull(Type::float())],
            'quantity' => ['type' => Type::nonNull(Type::int())],
        ];
    }

    public function resolve($root, $args)
    {
        return Product::create($args);
    }
}
