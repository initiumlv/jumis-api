<?php

namespace Initium\Jumis\Api\Enums\Fields\FinancialDoc;

enum FinancialDocLineDimension: string
{
    case LinkID = 'LineDimensionLinkID'; // int
    case ID = 'LineDimensionID'; // int
    case Code = 'LineDimensionCode'; // varchar(10)
    case Name = 'LineDimensionName'; // varchar(255)
    case TypeID = 'LineDimensionTypeID'; // int - Read only
    case TypeCode = 'LineDimensionTypeCode'; // varchar(10) - Read only
    case TypeName = 'LineDimensionTypeName'; // varchar(10) - Read only
} 