<?php

namespace App\Listeners;

use App\Exports\CustomersExport;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Maatwebsite\Excel\Facades\Excel;

class ExportCustomerListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ExportCustomerListener $event): void
    {
        Excel::download(new CustomersExport, 'data-' . Carbon::now()->timestamp . '.xlsx');
    }
}
