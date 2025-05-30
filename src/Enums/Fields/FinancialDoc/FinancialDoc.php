<?php

namespace Initium\Jumis\Api\Enums\Fields\FinancialDoc;

enum FinancialDoc: string
{
    // Basic identification
    case ID = 'DocID'; // int
    case No = 'DocNo'; // varchar(50)
    case NoSerial = 'DocNoSerial'; // varchar(20)
    case Date = 'DocDate'; // datetime
    case CreateDate = 'DocCreateDate'; // datetime - Read only
    case UpdateDate = 'DocUpdateDate'; // datetime - Read only
    case RegistrationDate = 'DocRegistrationDate'; // datetime
    case RegistrationNo = 'DocRegistrationNo'; // varchar(50)
    
    // Group information
    case GroupID = 'DocGroupID'; // int
    case GroupName = 'DocGroupName'; // varchar(50)
    case GroupAbbreviation = 'DocGroupAbbreviation'; // varchar(25)
    
    // Type information
    case TypeID = 'DocTypeID'; // int
    case TypeName = 'DocTypeName'; // varchar(50)
    case TypeAbbreviation = 'DocTypeAbbreviation'; // varchar(25)
    
    // Partner information
    case PartnerID = 'DocPartnerID'; // int
    case PartnerName = 'DocPartnerName'; // varchar(358)
    case PartnerContactPerson = 'DocPartnerContactPerson'; // varchar(255)
    case PartnerRegistrationNo = 'DocPartnerRegistrationNo'; // varchar(50)
    case PartnerVatNo = 'DocPartnerVatNo'; // varchar(50)
    case PartnerVatNoCountryID = 'DocPartnerVatNoCountryID'; // int
    case PartnerVatNoCountryCode = 'DocPartnerVatNoCountryCode'; // varchar(3)
    
    // Company information
    case CompanyVatNo = 'DocCompanyVatNo'; // varchar(50)
    case CompanyVatNoCountryID = 'DocCompanyVatNoCountryID'; // int
    case CompanyVatNoCountryCode = 'DocCompanyVatNoCountryCode'; // varchar(3)
    
    // Contact information
    case ContactID = 'DocContactID'; // int
    case ContactName = 'DocContactName'; // varchar(306)
    
    // Amount and currency
    case Amount = 'DocAmount'; // money
    case AmountLockedNotice = 'DocAmountLockedNotice'; // varchar(100)
    case AmountLockedNoticeID = 'DocAmountLockedNoticeID'; // bit
    case Currency = 'DocCurrency'; // varchar(3)
    case CurrencyID = 'DocCurrencyID'; // int
    case CurrencyRateID = 'DocCurrencyRateID'; // int
    case CurrencyRate = 'DocCurrencyRate'; // decimal(25,10)
    
    // Disbursement information
    case DisbursementDate = 'DocDisbursementDate'; // datetime
    case DisbursementTerm = 'DocDisbursementTerm'; // datetime
    case DisbursementNotice = 'DocDisbursementNotice'; // varchar(100)
    case DisbursementNoticeID = 'DocDisbursementNoticeID'; // bit
    case DisbursementUnPaidAmount = 'DocDisbursementUnPaidAmount'; // money - Read only
    
    // Accounting information
    case AccountingObjectID = 'AccountingObjectID'; // int
    case AccountingObjectName = 'AccountingObjectName'; // varchar(50)
    case AccountingObjectAccountID = 'AccountingObjectAccountID'; // int
    case AccountingObjectAccountCode = 'AccountingObjectAccountCode'; // varchar(21)
    case AccountingObjectAccountName = 'AccountingObjectAccountName'; // varchar(50) - Read only
    case AccountingObjectCurrency = 'AccountingObjectCurrency'; // varchar(3)
    case AccountingObjectCurrencyID = 'AccountingObjectCurrencyID'; // int
    
    // Additional information
    case Comments = 'DocComments'; // varchar(255)
    case SemoDocGUID = 'SemoDocGUID'; // uniqueidentifier
} 