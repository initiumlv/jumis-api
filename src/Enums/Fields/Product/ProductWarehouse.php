<?php

namespace Initium\Jumis\Api\Enums\Fields\Product;

enum ProductWarehouse: string
{
    case ID = 'ProductWarehouseID'; // int
    case WarehouseID = 'WarehouseID'; // int
    case UtmostQuantity = 'WarehouseUtmostQuantity'; // money
    case QuantityUnit = 'WarehouseQuantityUnit'; // varchar(50)
    case QuantityUnitID = 'WarehouseQuantityUnitID'; // int
    case NecessaryQuantity = 'WarehouseNecessaryQuantity'; // money
    case Name = 'WarehouseName'; // varchar(409)
} 