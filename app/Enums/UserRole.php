<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Compliance = 'compliance';
    case Support = 'support';
    case Merchant = 'merchant';
}
