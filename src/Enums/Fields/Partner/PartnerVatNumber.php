<?php

namespace Initium\Jumis\Api\Enums\Fields\Partner;

enum PartnerVatNumber: string
{
    case ID = 'VatNoID'; // int
    case Number = 'VatNo'; // varchar(50)
    case CountryID = 'VatNoCountryID'; // int
    case CountryCode = 'VatNoCountryCode'; // varchar(3)
    case DefaultNotice = 'VatNoDefaultNotice'; // varchar(100)
    case DefaultNoticeID = 'VatNoDefaultNoticeID'; // bit
} 