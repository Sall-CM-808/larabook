<?php

namespace App\Policies;

use App\Models\Loan;
use App\Models\User;

class LoanPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Loan $loan): bool
    {
        if ($user->hasAnyRole(['admin', 'bibliothecaire'])) {
            return true;
        }

        return $user->id === $loan->user_id;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function return(User $user, Loan $loan): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function manageAll(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }
}
