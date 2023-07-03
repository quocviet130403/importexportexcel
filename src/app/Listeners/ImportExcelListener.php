<?php

namespace App\Listeners;

use App\Events\ImportCustomerEvent;
use App\Imports\CustomersImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class ImportExcelListener implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  //  public string $connection = 'database';
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(ImportCustomerEvent $event): void
    {

        try {
            $filePath = Storage::disk('uploads')->path($event->storedFile);
            $cleanedFileName = str_replace("\0", '', $filePath);
            // Excel::import(new CustomersImport(), $cleanedFileName);
        } catch (\Exception $e) {
            Log::info("ImportExcelListenerMess: " . $e->getMessage());
        }
    }
}
