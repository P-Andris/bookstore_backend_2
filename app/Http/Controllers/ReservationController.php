<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index() {
        $reservations = Reservation::all();
        return $reservations;
    }

    public function show($id) {
        $reservation = Reservation::find($id);
        return $reservation;
    }

    public function destroy($id) {
        Reservation::find($id)->delete();
    }

    public function store(Request $request) {
        $reservation = new Reservation();
        $reservation->book_id = $request->book_id;
        $reservation->user_id = $request->user_id;
        $reservation->start = $request->start;
        $reservation->message = $request->message;
        $reservation->save();
    }
    
    public function update(Request $request, $id) {
        $reservation = Reservation::find($id);
        $reservation->book_id = $request->book_id;
        $reservation->user_id = $request->user_id;
        $reservation->start = $request->start;
        $reservation->message = $request->message;
        $reservation->save();
    }


    // Lekérdezések
    /* public function countReservation($id) {
        $reservation = DB::table('reservations')
        ->where('user_id', '=', $id)
        ->count('*');
        return $reservation;
    } */

    // A bizonyos napnál régebbi előjegyzések listáját írja ki!
    public function older($day) {
        $user = Auth::user();
        $reservations = DB::table('reservations')
        ->select('reservations.book_id', 'reservations.start')
        ->where('reservations.user_id', $user->id)
        ->whereRaw('DATEDIFF(CURRENT_DATE, reservations.start) > ?', $day)
        ->get();
        return $reservations;
    }

    // Mennyi foglalása van a bejelentkezett felhasználónak?
    public function reservationCount() {
        $user = Auth::user();
        $reservation = DB::table('reservations')
        ->where('reservations.user_id', $user->id)
        ->count();
        return $reservation;
    }
}
