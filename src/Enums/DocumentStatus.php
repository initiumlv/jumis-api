<?php

namespace Initium\Jumis\Api\Enums;

enum DocumentStatus: int
{
    case STARTED = 1;      // Iesākts
    case ENTERED = 2;      // Ievadīts
    case APPROVED = 5;     // Apstiprināts
    case POSTED = 6;       // Kontēts

    public function label(): string
    {
        return match($this) {
            self::STARTED => 'Iesākts',
            self::ENTERED => 'Ievadīts',
            self::APPROVED => 'Apstiprināts',
            self::POSTED => 'Kontēts',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::STARTED => 'Document has been started',
            self::ENTERED => 'Document has been entered',
            self::APPROVED => 'Document has been approved',
            self::POSTED => 'Document has been posted',
        };
    }
} 