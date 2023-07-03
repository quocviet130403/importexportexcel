<?php

use App\Http\Controllers\Admin\CampusController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\GuestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\HomeController;
use App\Models\Event;
use App\Models\Guest;
use Illuminate\Support\Facades\Storage;
use Chumper\ZBar\ImageScanner;
use Chumper\ZBar\SymbolIterator;
use GuzzleHttp\Client;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

Auth::routes();

// Route::middleware('qrcode.scan')->group(function () {
// });
// Media
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('admin')->middleware('auth');

    //Customer
    Route::resource('customer', CustomerController::class);
    Route::get('customer/excel/import', [CustomerController::class, 'import'])->name('customer.import');
    Route::post('customer/excel/import/store', [CustomerController::class, 'importStore'])->name('customer.import.store');
    Route::get('customer/excel/export', [CustomerController::class, 'export'])->name('customer.export');      

    // //Nguoi tham gia
    // Route::resource('guest', GuestController::class);
    // Route::get('guest/create/import/{eventId}', [GuestController::class, 'createImport'])->name('guest.create.import');
    // Route::delete('guest/deleteAll/{eventId}', [GuestController::class, 'deleteAll'])->name('guest.deleteAll');
    // Route::get('/download-qr-codes/{eventId}', [GuestController::class, 'downloadQrCodes'])->name('guest.downloadQRCode');
    // Route::get('/welcome-qrcode/{token}', [ClientController::class, 'storeQR'])->name('client.storeQR');
    // Route::get('export/guest/{slugEvent?}', [GuestController::class, 'export'])->name('guest.export');

    // //Event
    // Route::get('event', [GuestController::class, 'list'])->name('event.list');
    // Route::get('event/create', [GuestController::class, 'createEvent'])->name('event.create');
    // Route::post('event/store', [GuestController::class, 'storeEvent'])->name('event.store');
    // Route::get('event/{id}/edit', [GuestController::class, 'editEvent'])->name('event.edit');
    // Route::put('event/update/{id}', [GuestController::class, 'updateEvent'])->name('event.update');
    // Route::delete('event/delete/{eventId}', [GuestController::class, 'deleteEvent'])->name('event.delete');

    // Nhân viên
    Route::get('change-pass', [UserController::class, 'changePass'])->name('user.change-pass');
    Route::middleware(['superAdmin'])->group(function () {
        Route::resource('user', UserController::class);
    });

    // //SCANALLQR
    // Route::get('/reset-qrcode/{eventId}/{start}/{end}', function ($eventId, $start, $end) {
    //     $guests = Event::find($eventId)->guests()->skip($start)->take($end)->get();
    //     foreach ($guests as $guest) {
    //         $filePath = 'files/excel/' . Str::slug($guest->fullname) . '-' . $guest->mssv . '-' . $guest->event->id . '.png';
    //         $absolutePath = storage_path('app/public/' . $filePath);

    //         if ($imageData = file_get_contents($absolutePath)) {

    //             $client = new Client();
    //             $response = $client->post('https://api.qrserver.com/v1/read-qr-code/', [
    //                 'multipart' => [
    //                     [
    //                         'name' => 'file',
    //                         'contents' => $imageData,
    //                         'filename' => 'qrcode.png'
    //                     ]
    //                 ]
    //             ]);

    //             $qrCodeData = json_decode($response->getBody(), true);
    //             $decodedText = $qrCodeData[0]['symbol'][0]['data'] ?? '';
    //             $qrcode = str_replace(url("admin/welcome-qrcode") . '/', "", $decodedText);// Trả về nội dung của mã QR
    //             $check = $guest->update(['qrcode' => $qrcode]);
    //         } else {
    //             return 'Image not found.';
    //         }
    //     }

    //     return 'done';
    // });

    //Campus
    // Route::resource('campus', CampusController::class);
});

?>
