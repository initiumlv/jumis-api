<?php

namespace Initium\Jumis\Api\Enums\Fields\Partner;

enum Partner: string
{
    // Basic identification
    case ID = 'PartnerID'; // int
    case Code = 'PartnerCode'; // varchar(50)
    case Name = 'PartnerName'; // varchar(255)
    case FullName = 'PartnerFullName'; // varchar(500) - Read only
    case TypeID = 'PartnerTypeID'; // int
    case Type = 'PartnerType'; // varchar(50)
    case KindID = 'PartnerKindID'; // tinyint
    case KindName = 'PartnerKindName'; // varchar(100)
    
    // Tax and registration
    case TaxpayerTypeID = 'PartnerTaxpayerTypeID'; // int
    case TaxpayerType = 'PartnerTaxpayerType'; // varchar(50)
    case RegistrationNo = 'PartnerRegistrationNo'; // varchar(50)
    case PersonalIdentityNo = 'PartnerPersonalIdentityNo'; // varchar(12)
    case SEZCode = 'PartnerSEZCode'; // varchar(50)
    case TerritorialCode = 'PartnerTerritorialCode'; // varchar(50)
    case ISKCode = 'ISKCode'; // varchar(25)
    case GLNCode = 'GLNCode'; // varchar(50)
    
    // Passport information
    case PassportNo = 'PartnerPassportNo'; // varchar(50)
    case PassportIssueDate = 'PartnerPassportIssueDate'; // datetime
    case OrganizationIssuedPassport = 'PartnerOrganizationIssuedPassport'; // varchar(255)
    
    // Contact information
    case Email = 'PartnerEmail'; // varchar(50)
    case Phone = 'PartnerPhone'; // varchar(50)
    case Fax = 'PartnerFax'; // varchar(50)
    case WebAddress = 'PartnerWebAddress'; // varchar(50)
    case Comments = 'PartnerComments'; // varchar(1000)
    case PrintableComments = 'PartnerPrintableComments'; // varchar(1000)
    
    // Name components
    case Title = 'PartnerTitle'; // varchar(50)
    case FirstName = 'PartnerFirstName'; // varchar(50)
    case Surname = 'PartnerSurname'; // varchar(50)
    case FirstNameAccusative = 'PhysicalPersonFirstNameAccusative'; // varchar(50)
    case FirstNameDative = 'PhysicalPersonFirstNameDative'; // varchar(50)
    
    // Credit information
    case CreditAmountLimit = 'PartnerCreditAmountLimit'; // money
    case CreditDueTime = 'PartnerCreditDueTime'; // int
    case CreditStateID = 'PartnerCreditStateID'; // Read only
    case CreditStateName = 'PartnerCreditStateName'; // Read only
    case CreditComments = 'PartnerCreditComments'; // varchar(255)
    case CreditStatussBlocked = 'PartnerCreditStatussBlocked'; // varchar(100)
    case CreditStatussBlockedNoticeID = 'PartnerCreditStatussBlockedNoticeID'; // bit
    
    // Debt information
    case DebtStatusDate = 'PartnerDebtStatusDate'; // Read only
    case DebtStatusTypeID = 'PartnerDebtStatusTypeID'; // int
    case DebtStatusTypeName = 'PartnerDebtStatusTypeName'; // varchar(100)
    case DebtAmountSumLVL = 'PartnerDebtAmountSumLVL'; // Read only
    case DebtOldestDate = 'PartnerDebtOldestDate'; // Read only
    case DebtAdminProcesID = 'PartnerDebtAdminProcesID'; // int
    case DebtAdminProcesName = 'PartnerDebtAdminProcesName'; // varchar(100)
    case DebtAdminProcesOrder = 'PartnerDebtAdminProcesOrder'; // int
    case DebtDemandType = 'PartnerDebtDemandType';
    
    // Payment information
    case PaymentFormTypeID = 'PartnerPaymentFormTypeID'; // int
    case PaymentFormTypeName = 'PartnerPaymentFormTypeName'; // varchar(50)
    case IncomeTypeID = 'PartnerIncomeTypeID'; // int
    case IncomeType = 'PartnerIncomeType'; // varchar(200)
    
    // Flags
    case LockedNotice = 'PartnerLockedNotice'; // varchar(100)
    case LockedNoticeID = 'PartnerLockedNoticeID'; // bit
    case ProductWarehouseNotice = 'PartnerProductWarehouseNotice'; // varchar(100)
    case ProductWarehouseNoticeID = 'PartnerProductWarehouseNoticeID'; // bit
    case ExpenseAccountHolderNotice = 'PartnerExpenseAccountHolderNotice'; // varchar(100)
    case ExpenseAccountHolderNoticeID = 'PartnerExpenseAccountHolderNoticeID'; // bit
    case TimberForwarderNotice = 'PartnerTimberForwarderNotice'; // varchar(100)
    case TimberForwarderNoticeID = 'PartnerTimberForwarderNoticeID'; // bit
} 