<?php

namespace Initium\Jumis\Api\Enums\Fields\Product;

enum Product: string
{
    // Basic identification
    case ID = 'ProductID'; // int
    case Code = 'ProductCode'; // varchar(20)
    case Name = 'ProductName'; // varchar(100)
    case Nick = 'ProductNick'; // varchar(20)
    case Comments = 'ProductComments'; // varchar(255)
    case Certificate = 'ProductCertificate'; // varchar(100)
    case BarCode = 'ProductBarCode'; // varchar(20)
    
    // Expiry information
    case ExpiryDay = 'ProductExpiryDay'; // tinyint
    case ExpiryMonth = 'ProductExpiryMonth'; // tinyint
    case ExpiryHour = 'ProductExpiryHour'; // tinyint
    
    // Origin information
    case OriginCountryID = 'ProductOriginCountryID'; // int
    case OriginCountryCode = 'ProductOriginCountryCode'; // varchar(3)
    case OriginCountryName = 'ProductOriginCountryName'; // varchar(50)
    case CnCode = 'ProductCnCode'; // varchar(20)
    
    // Unit information
    case Unit = 'ProductUnit'; // varchar(50)
    case UnitID = 'ProductUnitID'; // int
    
    // Type and classification
    case TypeID = 'ProductTypeID'; // int
    case TypeCode = 'ProductTypeCode'; // varchar(20)
    case TypeName = 'ProductTypeName'; // varchar(50)
    case ClassName = 'ProductClassName'; // varchar(50)
    case ClassAbbreviation = 'ProductClassAbbreviation'; // varchar(20)
    case ClassID = 'ProductClassID'; // tinyint
} 