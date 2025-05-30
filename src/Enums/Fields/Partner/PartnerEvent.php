<?php

namespace Initium\Jumis\Api\Enums\Fields\Partner;

enum PartnerEvent: string
{
    case ID = 'EventID'; // int
    case Record = 'EventRecord'; // varchar(1000)
    case Date = 'EventDate'; // datetime
    case TypeID = 'EventTypeID'; // int
    case Type = 'EventType'; // varchar(50)
    case ContactPerson = 'EventContactPerson'; // varchar(50)
    case CompanyDeputy = 'EventCompanyDeputy'; // varchar(50)
    case DurationMinutes = 'EventDurationMinutes'; // tinyint
    case DurationHours = 'EventDurationHours'; // tinyint
} 