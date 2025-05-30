<?php

namespace Initium\Jumis\Api\Enums\Fields\FinancialDoc;

enum FinancialDocExtraInfo: string
{
    case LinkID = 'DocExtraInfoLinkID'; // int
    case ID = 'DocExtraInfoID'; // int
    case Name = 'DocExtraInfoName'; // varchar(255)
    case Info = 'DocExtraInfo'; // varchar(1000)
    case FormatID = 'DocExtraInfoFormatID'; // int
} 