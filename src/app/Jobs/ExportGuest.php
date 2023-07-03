<?php

namespace App\Jobs;

use App\Exports\GuestExport;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExportGuest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private string $slugEvent;
    public function __construct(String $slugEvent)
    {
        $this->slugEvent = $slugEvent;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $tempDir = storage_path('app/temp-images/');
        if (!file_exists($tempDir)) {
            mkdir($tempDir);
        }

        $tempExport = storage_path('app/exports/');
        if (!file_exists($tempExport)) {
            mkdir($tempExport);
        }

        $guests = Event::where('slug', $this->slugEvent)->first()->guests;
        $export = new GuestExport($guests, $tempDir);
        $filename = $this->slugEvent . '-' . Carbon::now()->timestamp . '.xlsx';
        Excel::store($export, 'exports/' . $filename);

        return response()->download($tempExport . $filename, $filename)->deleteFileAfterSend(true);
    }
}
