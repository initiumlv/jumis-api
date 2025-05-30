<?php

namespace Initium\Jumis\Api\Enums\Fields\FinancialDoc;

enum FinancialDocDimension: string
{
    case LinkID = 'DocDimensionLinkID'; // int
    case ID = 'DocDimensionID'; // int
    case Code = 'DocDimensionCode'; // varchar(10)
    case Name = 'DocDimensionName'; // varchar(255)
    case TypeID = 'DocDimensionTypeID'; // int - Read only
    case TypeCode = 'DocDimensionTypeCode'; // varchar(10) - Read only
    case TypeName = 'DocDimensionTypeName'; // varchar(10) - Read only
} 