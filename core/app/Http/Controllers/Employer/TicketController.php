<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Traits\SupportTicketManager;

class TicketController extends Controller
{
    use SupportTicketManager;

    public function __construct()
    {
        parent::__construct();
        $this->layout = 'master';
        $this->redirectLink = 'employer.ticket.view';
        $this->userType     = 'employer';
        $this->column       = 'employer_id';
        $this->user = auth()->guard('employer')->user();
        if ($this->user) {
            $this->layout = 'master';
        }
    }
}
