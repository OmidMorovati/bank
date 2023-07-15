<?php

namespace App\Enums;

enum AccountDescription
{
    case OPEN_NEW_ACCOUNT;
    case MONEY_TRANSFER;

    public function description(): string
    {
        return match($this)
        {
            self::OPEN_NEW_ACCOUNT => 'open new account',
            self::MONEY_TRANSFER => 'money transfer',
        };
    }
}
