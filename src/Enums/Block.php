<?php

namespace Initium\Jumis\Api\Enums;

enum Block: string
{
    case Product = 'Product';
    case Partner = 'Partner';
    case ProductPrice = 'ProductPrice';
    case Account = 'Account';
    case Dimension = 'Dimension';
    case Document = 'Document';
    case ProductGroup = 'ProductGroup';
    case PartnerGroup = 'PartnerGroup';
    case Currency = 'Currency';
    case Warehouse = 'Warehouse';
    case User = 'User';
    case DocumentType = 'DocumentType';
    case TaxRate = 'TaxRate';
    case Unit = 'ProductUnit';
    case ProductType = 'ProductType';
    case PriceType = 'PriceType';
    case Project = 'Project';
    case Company = 'Company';
    case Location = 'Location';
    case Language = 'Language';
    case PaymentTerm = 'PaymentTerm';
    case Country = 'Country';
    case City = 'City';
    case Contact = 'Contact';
    case Bank = 'Bank';
    case BankAccount = 'BankAccount';
    case VatCode = 'VatCode';
    case Contract = 'Contract';
}

