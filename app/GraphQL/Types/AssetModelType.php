<?php

namespace App\GraphQL\Types;

use App\Models\AssetModel;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class AssetModelType extends GraphQLType
{
    protected $attributes = [
        'name' => 'AssetModel',
        'description' => 'An asset model',
        'model' => AssetModel::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The unique identifier',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The model name',
            ],
            'model_number' => [
                'type' => Type::string(),
                'description' => 'The model number',
            ],
            'manufacturer_id' => [
                'type' => Type::int(),
                'description' => 'The manufacturer ID',
            ],
            'category_id' => [
                'type' => Type::int(),
                'description' => 'The category ID',
            ],
            'notes' => [
                'type' => Type::string(),
                'description' => 'Notes about the model',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'When created',
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'When last updated',
            ],
        ];
    }
}
