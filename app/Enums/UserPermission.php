<?php

namespace App\Enums;

enum UserPermission: string
{
    case AccessAdmin = 'access admin';
    case AccessMerchantDashboard = 'access merchant dashboard';
    case CreateEscrowLinks = 'create escrow links';
    case ViewTransactions = 'view transactions';
    case ViewMerchants = 'view merchants';
    case ReviewKyc = 'review kyc';
    case ManageDisputes = 'manage disputes';
    case ManagePayouts = 'manage payouts';
    case ManageUsers = 'manage users';
}
