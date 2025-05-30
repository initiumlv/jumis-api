<?php

namespace Initium\Jumis\Api\Enums\Fields\StoreDoc;

enum StoreDocVatAmount: string
{
    case StoreDocID = 'VatStoreDocID'; // int - Read only
    case BaseAmount = 'VatBaseAmount'; // money - Read only
    case Amount = 'VatAmount'; // money - Read only
    case Rate = 'VatRate'; // money - Read only
} 