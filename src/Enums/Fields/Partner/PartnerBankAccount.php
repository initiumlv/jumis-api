<?php

namespace Initium\Jumis\Api\Enums\Fields\Partner;

enum PartnerBankAccount: string
{
    case ID = 'AccountID'; // int
    case Number = 'AccountNo'; // varchar(50)
    case FullName = 'AccountFullName'; // varchar(500) - Read only
    case BankID = 'AccountBankID'; // int
    case BankCode = 'AccountBankCode'; // varchar(50)
    case BankName = 'AccountBankName'; // varchar(255)
    case SubaccountNo = 'AccountSubaccountNo'; // varchar(50)
    case Currency = 'AccountCurrency'; // varchar(3)
    case CurrencyID = 'AccountCurrencyID'; // int
    case Comments = 'AccountComments'; // varchar(255)
    case DefaultNotice = 'AccountDefaultNotice'; // varchar(100)
    case DefaultNoticeID = 'AccountDefaultNoticeID'; // bit
} 