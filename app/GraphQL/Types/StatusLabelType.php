<?php

namespace App\GraphQL\Types;

use App\Models\Statuslabel;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class StatusLabelType extends GraphQLType
{
    protected $attributes = [
        'name' => 'StatusLabel',
        'description' => 'A status label',
        'model' => Statuslabel::class,
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
                'description' => 'The status label name',
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
