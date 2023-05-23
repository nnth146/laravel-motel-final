<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    //
    public function update(Request $request, Avatar $avatar) : RedirectResponse
    {
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars');

            if($avatar->src){
                Storage::delete($avatar->src);
            }

            $avatar = Avatar::updateOrCreate(
                ['user_id' => Auth::id(),],
                ['src' => $path],
            );
        }

        return back();
    }

    public function destroy(Request $request, Avatar $avatar) : RedirectResponse
    {
        Storage::delete($avatar->src);

        $avatar->delete();

        return back();
    }
}
