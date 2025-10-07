<?php

namespace App\Traits;

use App\Constants\Status;

trait EmployerNotify
{
    public static function notifyToEmployer()
    {
        return [
            'allEmployers'               => 'All Employers',
            'selectedEmployers'          => 'Selected Employers',
            'withBalance'                => 'With Balance Employers',
            'emptyBalanceEmployers'      => 'Empty Balance Employers',
            'twoFaDisableEmployers'      => '2FA Disable Employers',
            'twoFaEnableEmployers'       => '2FA Enable Employers',
            'hasDepositedEmployers'      => 'Employers With Payment',
            'notDepositedEmployers'      => 'Employers With Not Payment',
            'pendingDepositedEmployers'  => 'Employers With Pending Payment',
            'rejectedDepositedEmployers' => 'Employers With Rejected Payment',
            'topDepositedEmployers'      => 'Employers With Top Payment',
            'pendingTicketEmployers'     => 'Pending Ticket Employers',
            'answerTicketEmployers'      => 'Answer Ticket Employers',
            'closedTicketEmployers'      => 'Closed Ticket Employers',
            'notLoginEmployers'          => 'Last Few Days Not Login Employers',
            'notPostJobEmployers'        => 'Employers Not Post a Job',
            'notHavePlanSubscription'    => 'Employers Doesn\'t Buy Plan Subscription',
            'expiredPlanSubscription'    => 'Subscription Expired Employers'
        ];
    }

    public function scopeSelectedEmployers($query)
    {
        return $query->whereIn('id', request()->user ?? []);
    }

    public function scopeAllEmployers($query)
    {
        return $query;
    }

    public function scopeWithBalance($query)
    {
        return $query->where('balance', '>', 0);
    }

    public function scopeEmptyBalanceEmployers($query)
    {
        return $query->where('balance', '<=', 0);
    }

    public function scopeTwoFaDisableEmployers($query)
    {
        return $query->where('ts', Status::DISABLE);
    }

    public function scopeTwoFaEnableEmployers($query)
    {
        return $query->where('ts', Status::ENABLE);
    }

    public function scopeHasDepositedEmployers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->successful();
        });
    }

    public function scopeNotDepositedEmployers($query)
    {
        return $query->whereDoesntHave('deposits', function ($q) {
            $q->successful();
        });
    }

    public function scopePendingDepositedEmployers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->pending();
        });
    }

    public function scopeRejectedDepositedEmployers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->rejected();
        });
    }

    public function scopeTopDepositedEmployers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->successful();
        })->withSum(['deposits' => function ($q) {
            $q->successful();
        }], 'amount')->orderBy('deposits_sum_amount', 'desc')->take(request()->number_of_top_deposited_user ?? 10);
    }

    public function scopePendingTicketEmployers($query)
    {
        return $query->whereHas('tickets', function ($q) {
            $q->whereIn('status', [Status::TICKET_OPEN, Status::TICKET_REPLY]);
        });
    }

    public function scopeClosedTicketEmployers($query)
    {
        return $query->whereHas('tickets', function ($q) {
            $q->where('status', Status::TICKET_CLOSE);
        });
    }

    public function scopeAnswerTicketEmployers($query)
    {
        return $query->whereHas('tickets', function ($q) {

            $q->where('status', Status::TICKET_ANSWER);
        });
    }

    public function scopeNotLoginEmployers($query)
    {
        return $query->whereDoesntHave('loginLogs', function ($q) {
            $q->whereDate('created_at', '>=', now()->subDays(request()->number_of_days ?? 10));
        });
    }

    public function scopeNotPostJobEmployers($query)
    {
        return $query->whereDoesntHave('jobs');
    }

    public function scopeNotHavePlanSubscription($query)
    {
        return $query->whereDoesntHave('subscriptions');
    }

    public function scopeExpiredPlanSubscription($query)
    {
        return $query->whereHas('subscriptions', function ($subscription) {
            $subscription->expired();
        });
    }
}
