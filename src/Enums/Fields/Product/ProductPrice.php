<?php

namespace Initium\Jumis\Api\Enums\Fields\Product;

enum ProductPrice: string
{
    case ID = 'ProductPriceID'; // int
    case Price = 'Price'; // money
    case TypeID = 'PriceTypeID'; // int
    case TypeName = 'PriceTypeName'; // varchar(50)
    case Currency = 'PriceCurrency'; // varchar(3)
    case CurrencyID = 'PriceCurrencyID'; // int
} 