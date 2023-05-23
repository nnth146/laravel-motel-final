<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Rate;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function search(Request $request)
    {
        $search = $request->input('search', '');

        if (empty($search)) return collect();

        $rooms = collect([]);

        foreach (Room::all() as $room) {
            if (str_contains($room->name, $search)) {
                $rooms->push($room);
            }
        }

        return $rooms->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('room.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required'],
            'quantity' => ['required', 'integer'],
            'price' => ['required'],
            'description' => ['required'],
        ]);

        $room = Room::create([
            'user_id' => Auth::id(),
            'name' => $request->input('name'),
            'quantity' => $request->input('quantity'),
            'price' => (int)str_replace('.', '', $request->input('price')),
            'price_text' => $request->input('price'),
            'description' => $request->input('description'),
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->photos as $photo) {
                $path = Storage::putFile('images', $photo);

                Image::create([
                    'room_id' => $room->id,
                    'src' => $path,
                ]);
            }
        }

        return redirect()->route('users.edit');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $rates = Rate::where('room_id', '=', $room->id)
            ->where('user_id', '<>', Auth::id())
            ->orderBy('updated_at')
            ->paginate(5);

        return view('room.show', ['room' => $room, 'rates' => $rates]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return view('room.edit', ['room' => $room]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $this->authorize('update', $room);

        $request->validate([
            'name' => ['required'],
            'quantity' => ['required', 'integer'],
            'price' => ['required'],
            'description' => ['required'],
        ]);

        $room->name = $request->input('name');
        $room->quantity = $request->input('quantity');
        $room->price = (int)str_replace('.', '', $request->input('price'));
        $room->price_text = $request->input('price');
        $room->description = $request->input('description');

        $room->save();

        if ($request->hasFile('photos')) {
            //Delete all old image
            foreach ($room->images as $image) {
                Storage::delete($image->src);
                $image->delete();
            }

            foreach ($request->photos as $photo) {
                $path = Storage::putFile('images', $photo);

                Image::create([
                    'room_id' => $room->id,
                    'src' => $path,
                ]);
            }
        }

        return redirect()->route('users.edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room): RedirectResponse
    {
        $this->authorize('delete', $room);

        $room->delete();

        return redirect()->route('users.edit');
    }
}
