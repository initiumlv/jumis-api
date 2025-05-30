<?php

namespace Initium\Jumis\Api\Enums\Fields\Product;

enum ProductExtraInfo: string
{
    case LinkID = 'ExtraInfoLinkID'; // int
    case ID = 'ExtraInfoID'; // int
    case Name = 'ExtraInfoName'; // varchar(255)
    case Info = 'ExtraInfo'; // varchar(1000)
    case FormatID = 'ExtraInfoFormatID'; // int
} 