<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RateController extends Controller
{
    public function store(Request $request, Room $room)
    {
        Validator::validate(
            $request->all(),
            [
                'rate' => 'integer|min:1',
                'comment' => 'required',
            ],
            ['rate' => 'Điểm đánh giá ít nhất bằng 1']
        );

        Rate::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'point' => $request->input('rate'),
            'comment' => $request->input('comment'),
        ]);

        return back();
    }

    public function update(Request $request, Rate $rate)
    {
        Validator::validate(
            $request->all(),
            [
                'rate' => 'integer|min:1',
                'comment' => 'required',
            ],
            ['rate' => 'Điểm đánh giá ít nhất bằng 1']
        );


        $rate->point = $request->input('rate');
        $rate->comment = $request->input('comment');

        $rate->save();

        return back();
    }

    public function destroy(Request $request, Rate $rate)
    {
        $rate->delete();

        return back();
    }
}
