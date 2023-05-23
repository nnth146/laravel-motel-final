<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Models\Room;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (Request $request) {
    $sort = $request->input('sort') ?? 'byName';
    $search = $request->input('search');

    $perPage = 3;

    switch ($sort) {
        case 'byName':
            if (empty($search)) {
                $rooms = Room::orderBy('name')->paginate($perPage);
            } else {
                $rooms = Room::where('name', '=', $search)->orderBy('name')->paginate($perPage);
            }
            break;
        case 'byPrice':
            if (empty($search)) {
                $rooms = Room::orderBy('price')->paginate($perPage);
            } else {
                $rooms = Room::where('name', '=', $search)->orderBy('price')->paginate($perPage);
            }
            break;
        case 'byRate':
            if (empty($search)) {
                $rooms = Room::all();
                $avgRates = collect([]);
                foreach ($rooms as $room) {
                    $avgRates->push(['room' => $room, 'avgPoint' => $room->avgPoint()]);
                }
                $rooms = $avgRates->sortByDesc('avgPoint');
                $rooms = $rooms->map(function (array $item, int $key) {
                    return $item['room'];
                });
                $page = Paginator::resolveCurrentPage();
                $rooms = new LengthAwarePaginator($rooms->forPage($page, $perPage), $rooms->count(), $perPage);
            }else{
                $rooms = Room::all();
                $avgRates = collect([]);
                foreach ($rooms as $room) {
                    $avgRates->push(['room' => $room, 'avgPoint' => $room->avgPoint()]);
                }
                $rooms = $avgRates->sortByDesc('avgPoint');
                $rooms = $rooms->map(function (array $item, int $key) {
                    return $item['room'];
                });
                $rooms = $rooms->where('name', $search);
                $page = Paginator::resolveCurrentPage();
                $rooms = new LengthAwarePaginator($rooms->forPage($page, $perPage), $rooms->count(), $perPage);
            }
            break;
        default:
            $rooms = Room::orderBy('name')->paginate($perPage);
            break;
    }

    $rooms->withQueryString();

    return view('welcome', ['rooms' => $rooms, 'sort' => $sort, 'search' => $search]);
})->name('home');

Route::get('rooms/search', [RoomController::class, 'search']); // return response for script

Route::resource('rooms', RoomController::class)->except(['show', 'index'])->middleware('auth');

Route::resource('rooms', RoomController::class)->only(['show']);

require __DIR__ . '/auth.php';
