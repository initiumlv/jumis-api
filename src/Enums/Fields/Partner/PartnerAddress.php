<?php

namespace Initium\Jumis\Api\Enums\Fields\Partner;

enum PartnerAddress: string
{
    case ID = 'AddressID'; // int
    case Street = 'AddressStreet'; // varchar(250)
    case Full = 'AddressFull'; // varchar(300) - Read only
    case PostalCode = 'AddressPostalCode'; // varchar(50)
    case City = 'AddressCity'; // varchar(50)
    case Region = 'AddressRegion'; // varchar(50)
    case CountryID = 'AddressCountryID'; // int
    case CountryCode = 'AddressCountryCode'; // varchar(3)
    case CountryName = 'AddressCountryName'; // varchar(50)
    case Comments = 'AddressComments'; // varchar(255)
    case GLNCode = 'AddressGLNCode'; // varchar(50)
    case JuridicalNotice = 'AddressJuridicalNotice'; // varchar(100)
    case JuridicalNoticeID = 'AddressJuridicalNoticeID'; // bit
    case DefaultNotice = 'AddressDefaultNotice'; // varchar(100)
    case DefaultNoticeID = 'AddressDefaultNoticeID'; // bit
} 