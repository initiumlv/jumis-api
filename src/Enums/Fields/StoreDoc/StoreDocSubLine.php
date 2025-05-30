<?php

namespace Initium\Jumis\Api\Enums\Fields\StoreDoc;

enum StoreDocSubLine: string
{
    // Basic identification
    case ID = 'SubLineID'; // int
    case Comments = 'SubLineComments'; // varchar(255)
    
    // Product information
    case ProductID = 'SubLineProductID'; // int
    case ProductCode = 'SubLineProductCode'; // varchar(20)
    case ProductName = 'SubLineProductName'; // varchar(100)
    case ProductExtraCode = 'SubLineProductExtraCode'; // varchar(50)
    case ProductBarCode = 'SubLineProductBarCode'; // varchar(20)
    case ProductUnit = 'SubLineProductUnit'; // varchar(50)
    case ProductUnitID = 'SubLineProductUnitID'; // int
    
    // Product classification
    case ProductClassName = 'SubLineProductClassName'; // varchar(50)
    case ProductClassAbbreviation = 'SubLineProductClassAbbreviation'; // varchar(20)
    case ProductClassID = 'SubLineProductClassID'; // tinyint
    
    // Warehouse information
    case DeliveryWarehouseID = 'SubLineDeliveryWarehouseID'; // int
    case DeliveryWarehouseName = 'SubLineDeliveryWarehouseName'; // varchar(409)
    
    // Additional information
    case Quantity = 'SubLineQuantity'; // money
    case ExpiryDate = 'SubLineExpiryDate'; // datetime
    case Certificate = 'SubLineCertificate'; // varchar(100)
    case ProductCnCode = 'SubLineProductCnCode'; // varchar(20)
} 