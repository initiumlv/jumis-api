<?php

namespace Initium\Jumis\Api\Enums\Fields\FinancialDoc;

enum FinancialDocLine: string
{
    // Basic identification
    case ID = 'LineID'; // int
    case Comments = 'LineComments'; // varchar(255)
    
    // Payment information
    case PaymentCode = 'LinePaymentCode'; // char(3)
    
    // Budget information
    case BudgetItemID = 'LineBudgetItemID'; // int
    case BudgetItemCode = 'LineBudgetItemCode'; // varchar(20)
    case BudgetItemName = 'LineBudgetItemName'; // varchar(255) - Read only
    
    // Debit account information
    case DebetAccountID = 'LineDebetAccountID'; // int
    case DebetAccountCode = 'LineDebetAccountCode'; // varchar(21)
    case DebetAccountName = 'LineDebetAccountName'; // varchar(50) - Read only
    case DebetDepartmentCode = 'LineDebetDepartmentCode'; // varchar(25)
    case DebetFundingTargetCode = 'LineDebetFundingTargetCode'; // varchar(25)
    case DebetEconClasifCodeCode = 'LineDebetEconClasifCodeCode'; // varchar(25)
    
    // Credit account information
    case CreditAccountID = 'LineCreditAccountID'; // int
    case CreditAccountCode = 'LineCreditAccountCode'; // varchar(21)
    case CreditAccountName = 'LineCreditAccountName'; // varchar(50) - Read only
    case CreditDepartmentCode = 'LineCreditDepartmentCode'; // varchar(25)
    case CreditFundingTargetCode = 'LineCreditFundingTargetCode'; // varchar(25)
    case CreditEconClasifCodeCode = 'LineCreditEconClasifCodeCode'; // varchar(25)
    
    // Amount and currency
    case Amount = 'LineAmount'; // money
    case VatRate = 'LineVatRate'; // money
    case Currency = 'LineCurrency'; // varchar(3)
    case CurrencyID = 'LineCurrencyID'; // int
    case CurrencyRateID = 'LineCurrencyRateID'; // int
    case CurrencyRate = 'LineCurrencyRate'; // decimal(25,10)
    
    // Additional information
    case SupplementaryNotice = 'LineSupplementaryNotice'; // varchar(100)
    case SupplementaryNoticeID = 'LineSupplementaryNoticeID'; // bit
    case PartnerISKCode = 'PartnerISKCode'; // varchar(25)
} 