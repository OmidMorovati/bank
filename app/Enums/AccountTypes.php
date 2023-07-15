<?php

namespace App\Enums;

enum AccountTypes: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAWAL = 'withdrawal';
}
