<?php

namespace App\GraphQL\Types;

use App\Models\Asset;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class AssetType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Asset',
        'description' => 'An asset in the system',
        'model' => Asset::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The unique identifier of the asset',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the asset',
            ],
            'asset_tag' => [
                'type' => Type::string(),
                'description' => 'The unique asset tag',
            ],
            'serial' => [
                'type' => Type::string(),
                'description' => 'The serial number of the asset',
            ],
            'model_id' => [
                'type' => Type::int(),
                'description' => 'The ID of the asset model',
            ],
            'status_id' => [
                'type' => Type::int(),
                'description' => 'The ID of the status label',
            ],
            'company_id' => [
                'type' => Type::int(),
                'description' => 'The ID of the company',
            ],
            'location_id' => [
                'type' => Type::int(),
                'description' => 'The ID of the current location',
            ],
            'rtd_location_id' => [
                'type' => Type::int(),
                'description' => 'The ID of the default location',
            ],
            'supplier_id' => [
                'type' => Type::int(),
                'description' => 'The ID of the supplier',
            ],
            'purchase_date' => [
                'type' => Type::string(),
                'description' => 'The purchase date',
            ],
            'purchase_cost' => [
                'type' => Type::float(),
                'description' => 'The purchase cost',
            ],
            'order_number' => [
                'type' => Type::string(),
                'description' => 'The order number',
            ],
            'notes' => [
                'type' => Type::string(),
                'description' => 'Notes about the asset',
            ],
            'warranty_months' => [
                'type' => Type::int(),
                'description' => 'Warranty period in months',
            ],
            'assigned_to' => [
                'type' => Type::int(),
                'description' => 'The ID of the entity this asset is assigned to',
            ],
            'assigned_type' => [
                'type' => Type::string(),
                'description' => 'The type of entity this asset is assigned to',
            ],
            'requestable' => [
                'type' => Type::boolean(),
                'description' => 'Whether the asset can be requested',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'When the asset was created',
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'When the asset was last updated',
            ],
            'model' => [
                'type' => GraphQL::type('AssetModel'),
                'description' => 'The asset model',
            ],
            'assetstatus' => [
                'type' => GraphQL::type('StatusLabel'),
                'description' => 'The status label',
            ],
        ];
    }
}
