<?php

use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/* 
Tạo các global function để sử dụng tại đây 
*/

/* Tạo ngẫu nhiên chuỗi */

function randStr($length = 10, $includeNumbers = true, $includeLetters = true, $includeSymbols = false): string
{
    $numbers = '0123456789';
    $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $symbols = '!@#$~%^&*()_+[]\\;\',./';
    $characters = '';

    if ($includeNumbers) {
        $characters .= $numbers;
    }

    if ($includeLetters) {
        $characters .= $letters;
    }

    if ($includeSymbols) {
        $characters .= $symbols;
    }

    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
