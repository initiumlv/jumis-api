<?php

namespace Initium\Jumis\Api\Enums\Fields\Partner;

enum PartnerPhysicalPerson: string
{
    case BirthDate = 'PhysicalPersonBirthDate'; // datetime
    case Gender = 'PhysicalPersonGender'; // tinyint
    case Pensioner = 'PhysicalPersonPensioner'; // bit
    case Prisoner = 'PhysicalPersonPrisoner'; // bit
    case TaxRegNo = 'PhysicalPersonTaxRegNo'; // varchar(50)
    case TaxSocialTypeID = 'PhysicalPersonTaxSocialTypeID'; // int
    case TaxDocumentNo = 'PhysicalPersonTaxDocumentNo'; // varchar(50)
    case TaxDocumentSerial = 'PhysicalPersonTaxDocumentSerial'; // varchar(50)
    case TaxDocumentOrganization = 'PhysicalPersonTaxDocumentOrganization'; // varchar(50)
    case URVNamount = 'PhysicalPersonURVNamount'; // bit
} 