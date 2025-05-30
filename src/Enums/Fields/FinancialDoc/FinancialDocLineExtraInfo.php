<?php

namespace Initium\Jumis\Api\Enums\Fields\FinancialDoc;

enum FinancialDocLineExtraInfo: string
{
    case LinkID = 'LineExtraInfoLinkID'; // int
    case ID = 'LineExtraInfoID'; // int
    case Name = 'LineExtraInfoName'; // varchar(255)
    case Info = 'LineExtraInfo'; // varchar(1000)
    case FormatID = 'LineExtraInfoFormatID'; // int
} 