<?php

namespace Initium\Jumis\Api\Enums;

enum Operation: string
{
    case Read = 'Read';
    case Insert = 'Insert';
    case Update = 'Update';
    case Delete = 'Delete';
}