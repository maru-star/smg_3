<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Venue;
use App\Models\Reservation;


class HomeController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth']);
  }

  public function index()
  {
    $user_id = auth()->user()->id;
    $user = User::find($user_id);
    $reservation = Reservation::where('user_id', $user_id)->get();
    return view('user.home.index', [
      'user' => $user,
      'reservation' => $reservation
    ]);
  }

  public function show($id)
  {
    $reservation = Reservation::find($id);
    $venue = Venue::find($reservation->venue_id);

    return view('user.home.show', [
      'reservation' => $reservation,
      'venue' => $venue,
    ]);
  }

  public function updateReservationStatus(Request $request, $id)
  {
    $reservation = Reservation::find($id);
    $reservation->reservation_status = $request->update_status;
    $reservation->save();
    $request->session()->regenerate();
    return redirect()->route('user.home.index');
  }
}
