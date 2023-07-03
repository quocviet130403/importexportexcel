<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Event;
use App\Models\Guest;
use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;

class ClientController extends Controller
{
    public function show($slugCampus = null, $slugEvent = null)
    {
        $campus = Campus::where('slug', $slugCampus)->first();
        $event = Event::where('slug', $slugEvent)->first();
        if ($campus && $event) {
            return view('themes.default', compact('campus', 'event'));
        }
        return abort(404);
    }

    public function storeQR($token)
    {
        $qrcode = $token;
        $guest = Guest::where('qrcode', $qrcode)->first();
        if ($guest) {

            if ($guest->joined()) {
                return view('client.exist');
            }

            $data = [
                'fullname' => $guest->fullname,
                'mssv' => $guest->mssv
            ];
            $database = Firebase::database();
            $database->getReference('guests-' . $guest->event->campus->id . '-' . $guest->event->id)->push($data);

            $guest->update(['status' => 'JOINED']);

            return view('client.success', compact('data'));
        } else {
            return view('client.notfound');
        }
    }
}
