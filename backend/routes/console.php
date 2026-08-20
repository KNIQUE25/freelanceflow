<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('invoices:mark-overdue')->dailyAt('00:10');
Schedule::command('invoices:send-reminders')->dailyAt('08:00');
