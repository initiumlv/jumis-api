<?php

namespace Initium\Jumis\Api\Enums\Fields\StoreDoc;

enum StoreDocLine: string
{
    // Basic identification
    case ID = 'LineID'; // int
    case Comments = 'LineComments'; // varchar(255)
    
    // Product information
    case ProductID = 'LineProductID'; // int
    case ProductCode = 'LineProductCode'; // varchar(20)
    case ProductName = 'LineProductName'; // varchar(100)
    case ProductExtraCode = 'LineProductExtraCode'; // varchar(50)
    case ProductBarCode = 'LineProductBarCode'; // varchar(20)
    case ProductUnit = 'LineProductUnit'; // varchar(50)
    case ProductUnitID = 'LineProductUnitID'; // int
    
    // Product origin information
    case ProductOriginCountryID = 'LineProductOriginCountryID'; // int
    case ProductOriginCountryCode = 'LineProductOriginCountryCode'; // varchar(3)
    case ProductOriginCountryName = 'LineProductOriginCountryName'; // varchar(50)
    case ProductCnCode = 'LineProductCnCode'; // varchar(20)
    
    // Product classification
    case ProductClassName = 'LineProductClassName'; // varchar(50)
    case ProductClassAbbreviation = 'LineProductClassAbbreviation'; // varchar(20)
    case ProductClassID = 'LineProductClassID'; // tinyint
    
    // Warehouse information
    case DestinationWarehouseID = 'LineDestinationWarehouseID'; // int
    case DestinationWarehouseName = 'LineDestinationWarehouseName'; // varchar(409)
    case DeliveryWarehouseID = 'LineDeliveryWarehouseID'; // int
    case DeliveryWarehouseName = 'LineDeliveryWarehouseName'; // varchar(409)
    
    // Quantity and price information
    case Quantity = 'LineQuantity'; // money
    case Price = 'LinePrice'; // decimal(25,13)
    case TaxPrice = 'LineTaxPrice'; // decimal(25,13)
    case PriceLvl = 'LinePriceLvl'; // decimal(25,13)
    case PurchasePrice = 'LinePurchasePrice'; // decimal(25,13)
    case Cost = 'LineCost'; // decimal(25,13)
    case Total = 'LineTotal'; // money
    
    // Discount and tax information
    case Discount = 'LineDiscount'; // money
    case VatRate = 'LineVatRate'; // money
    case ExciseTax = 'LineExciseTax'; // money
    
    // Fuel specific information
    case FuelDensity = 'LineFuelDensity'; // money
    case FuelSulphurContent = 'LineFuelSulphurContent'; // varchar(100)
    case FuelTemperature = 'LineFuelTemperature'; // money
    
    // Additional information
    case ExpiryDate = 'LineExpiryDate'; // datetime
    case Certificate = 'LineCertificate'; // varchar(100)
} 