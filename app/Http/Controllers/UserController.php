<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Models\Room;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function edit(Request $request): View
    {
        $sort = $request->input('sort') ?? 'byName';
        $search = $request->input('search');

        $perPage = 15;

        switch ($sort) {
            case 'byName':
                if (empty($search)) {
                    $rooms = Room::where('user_id', '=', Auth::id())->orderBy('name')->paginate($perPage);
                } else {
                    $rooms = Room::where('user_id', '=', Auth::id())->where('name', '=', $search)->orderBy('name')->paginate($perPage);
                }
                break;
            case 'byPrice':
                if (empty($search)) {
                    $rooms = Room::where('user_id', '=', Auth::id())->orderBy('price')->paginate($perPage);
                } else {
                    $rooms = Room::where('user_id', '=', Auth::id())->where('name', '=', $search)->orderBy('price')->paginate($perPage);
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
                $rooms = Room::where('user_id', '=', Auth::id())->paginate($perPage);
                break;
        }

        $rooms->withQueryString();

        return view('user.edit', ['rooms' => $rooms, 'sort' => $sort, 'search' => $search]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email' => ['required', 'email'],
            'name' => ['required'],
            'phone' => ['required'],
        ]);

        $user->email = $validated['email'];
        $user->name = $validated['name'];
        $user->phone = $validated['phone'];

        $user->save();

        return back()->withInput(['avatar']);
    }

    public function search(Request $request)
    {
        $user = Auth::user();

        $search = $request->input('search', '');

        if (empty($search)) return collect();

        $rooms = collect([]);

        foreach ($user->rooms as $room) {
            if (str_contains($room->name, $search)) {
                $rooms->push($room);
            }
        }

        return $rooms->toJson();
    }
}
