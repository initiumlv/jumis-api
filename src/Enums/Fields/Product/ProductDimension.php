<?php

namespace Initium\Jumis\Api\Enums\Fields\Product;

enum ProductDimension: string
{
    case LinkID = 'DimensionLinkID'; // int
    case ID = 'DimensionID'; // int
    case Code = 'DimensionCode'; // varchar(10)
    case Name = 'DimensionName'; // varchar(255)
    case TypeID = 'DimensionTypeID'; // int - Read only
    case TypeCode = 'DimensionTypeCode'; // varchar(10) - Read only
    case TypeName = 'DimensionTypeName'; // varchar(255) - Read only
} 