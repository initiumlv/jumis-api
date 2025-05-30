<?php

namespace Initium\Jumis\Api\Enums\Fields\Partner;

enum PartnerContactPerson: string
{
    case ID = 'ContactPersonID'; // int
    case FullName = 'ContactPersonFullName'; // varchar(300) - Read only
    case FirstName = 'ContactPersonFirstName'; // varchar(50)
    case Surname = 'ContactPersonSurname'; // varchar(50)
    case Title = 'ContactPersonTitle'; // varchar(50)
    case Position = 'ContactPersonPosition'; // varchar(50)
    case Phone = 'ContactPersonPhone'; // varchar(50)
    case Email = 'ContactPersonEmail'; // varchar(50)
    case IdentityNo = 'ContactPersonIdentityNo'; // varchar(50)
    case IdentityDocument = 'ContactPersonIdentityDocument'; // varchar(255)
    case Comments = 'ContactPersonComments'; // varchar(255)
    
    // Address fields
    case AddressID = 'ContactPersonAddressID'; // int
    case AddressStreet = 'ContactPersonAddressStreet'; // varchar(250)
    case AddressFull = 'ContactPersonAddressFull'; // varchar(300) - Read only
    case AddressPostalCode = 'ContactPersonAddressPostalCode'; // varchar(50)
    case AddressCity = 'ContactPersonAddressCity'; // varchar(50)
    case AddressRegion = 'ContactPersonAddressRegion'; // varchar(50)
    case AddressCountryID = 'ContactPersonAddressCountryID'; // int
    case AddressCountryCode = 'ContactPersonAddressCountryCode'; // varchar(3)
    case AddressCountryName = 'ContactPersonAddressCountryName'; // varchar(50)
    case AddressComments = 'ContactPersonAddressComments'; // varchar(255)
} 