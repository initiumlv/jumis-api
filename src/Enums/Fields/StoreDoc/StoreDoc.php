<?php

namespace Initium\Jumis\Api\Enums\Fields\StoreDoc;

enum StoreDoc: string
{
    // Basic identification
    case ID = 'DocID'; // int
    case No = 'DocNo'; // varchar(50)
    case NoSerial = 'DocNoSerial'; // varchar(20)
    case Date = 'DocDate'; // datetime
    case CreateDate = 'DocCreateDate'; // datetime - Read only
    case UpdateDate = 'DocUpdateDate'; // datetime - Read only
    case RegistrationDate = 'DocRegistrationDate'; // datetime - Read only
    case RegistrationNo = 'DocRegistrationNo'; // varchar(50) - Read only
    
    // Type information
    case TypeID = 'DocTypeID'; // int
    case TypeName = 'DocTypeName'; // varchar(50)
    case TypeAbbreviation = 'DocTypeAbbreviation'; // varchar(25)
    case TradeTypeID = 'DocTradeTypeID'; // int
    case TradeTypeName = 'DocTradeTypeName'; // varchar(50)
    
    // Status information
    case StatusID = 'DocStatusID'; // int - Read only
    case Status = 'DocStatus'; // varchar(50) - Read only
    
    // Partner information
    case PartnerID = 'DocPartnerID'; // int
    case PartnerName = 'DocPartnerName'; // varchar(358)
    case PartnerContactPersonID = 'DocPartnerContactPersonID'; // int
    case PartnerContactPersonName = 'DocPartnerContactPersonName'; // varchar(101)
    case PartnerRegistrationNo = 'DocPartnerRegistrationNo'; // varchar(50)
    case PartnerEmail = 'DocPartnerEmail'; // varchar(50)
    case PartnerStoreAddress = 'DocPartnerStoreAddress'; // varchar(250)
    case PartnerStoreGLNCode = 'DocPartnerStoreGLNCode'; // nvarchar(50)
    case PartnerVatNo = 'DocPartnerVatNo'; // varchar(50)
    case PartnerVatNoCountryID = 'DocPartnerVatNoCountryID'; // int
    case PartnerVatNoCountryCode = 'DocPartnerVatNoCountryCode'; // varchar(3)
    
    // Company information
    case CompanyStoreAddress = 'DocCompanyStoreAddress'; // varchar(250)
    case CompanyVatNo = 'DocCompanyVatNo'; // varchar(50)
    case CompanyVatNoCountryID = 'DocCompanyVatNoCountryID'; // int
    case CompanyVatNoCountryCode = 'DocCompanyVatNoCountryCode'; // varchar(3)
    
    // Contact information
    case ContactID = 'DocContactID'; // int
    case ContactName = 'DocContactName'; // varchar(306)
    
    // Amount and currency
    case Amount = 'DocAmount'; // money - Read only
    case Total = 'DocTotal'; // money - Read only
    case Currency = 'DocCurrency'; // varchar(3)
    case CurrencyID = 'DocCurrencyID'; // int
    case CurrencyRateID = 'DocCurrencyRateID'; // int
    case CurrencyRate = 'DocCurrencyRate'; // decimal(25,10)
    
    // Discount information
    case DiscountPercentage = 'DocDiscountPercentage'; // money
    case DiscountAmount = 'DocDiscountAmount'; // money
    
    // VAT information
    case DefaultVatRate = 'DocDefaultVatRate'; // money
    case DefaultVatRateID = 'DocDefaultVatRateID'; // int
    case VatTotal = 'DocVatTotal'; // money - Read only
    
    // Accounting information
    case AccountingTemplate = 'DocAccountingTemplate'; // varchar(100)
    case AccountingTemplateID = 'DocAccountingTemplateID'; // int
    case TotalFormula = 'DocTotalFormula'; // varchar(100)
    case TotalFormulaID = 'DocTotalFormulaID'; // tinyint
    
    // Delivery information
    case DeliveryDate = 'DocDeliveryDate'; // datetime
    case DisbursementTerm = 'DocDisbursementTerm'; // datetime
    case DisbursementComments = 'DocDisbursementComments'; // varchar(255)
    
    // Timber specific information
    case TimberCuttingTicket = 'TimberCuttingTicket'; // varchar(250)
    case TimberDealDescription = 'TimberDealDescription'; // varchar(250)
    case TimberDealTypeID = 'TimberDealTypeID'; // tinyint
    case TimberDealType = 'TimberDealType'; // varchar(100)
    case TimberServiceType = 'TimberServiceType'; // varchar(250)
    case TimberForwarderID = 'TimberForwarderID'; // int
    case TimberForwarderName = 'TimberForwarderName'; // varchar(358)
    case TimberVehicleRegNo = 'TimberVehicleRegNo'; // varchar(250)
    case TimberVehicleDriver = 'TimberVehicleDriver'; // varchar(250)
    
    // Additional information
    case Comments = 'DocComents'; // varchar(1000)
    case SemoDocGUID = 'SemoDocGUID'; // uniqueidentifier
    case TelemaDocID = 'TelemaDocID'; // int
} 