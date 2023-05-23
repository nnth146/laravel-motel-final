<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Rate;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::deleteDirectory('avatars');
        Storage::deleteDirectory('images');
        $files = Storage::allFiles('example');
        $avatars = Storage::allFiles('avatar_example');


        DB::table('users')->insert([
            [
                'name' => 'tuanhung',
                'email' => 'nnthdeveloper@gmail.com',
                'password' => Hash::make('hungdeptrai'),
                'phone' => '0385328068',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);

        $userRecords = collect([]);
        $roomRecords = collect([]);
        $rateRecords = collect([]);

        for ($i = 0; $i < 20; $i++) {
            $userRecords->push([
                'name' => randStr(15, false),
                'email' => randStr(15) . '@gmail.com',
                'password' => Hash::make(randStr(15)),
                'phone' => randStr(10, true, false),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
        DB::table('users')->insert($userRecords->toArray());

        $prices = array('1.000.000' => 1000000, '200.000' => 200000, '500.000' => 500000);
        $randKeys = array_rand($prices, count($prices));
        $users = User::all();
        foreach ($users as $user) {
            for ($i = 0; $i < 2; $i++) {
                $rand = rand(0, 2);
                $key = $randKeys[$rand];

                $roomRecords->push([
                    'user_id' => $user->id,
                    'name' => 'Phòng ' . randStr(4, true, false),
                    'quantity' => rand(1, 10),
                    'price_text' => $key,
                    'price' => $prices[$key],
                    'description' => randStr(),
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ]);
            }
        }
        DB::table('rooms')->insert($roomRecords->toArray());

        $rooms = Room::all();
        $imageRecords = collect([]);
        foreach ($rooms as $room) {
            for ($i = 0; $i < rand(0, count($files)); $i++) {
                $file = new File('storage/app/' . $files[rand(0, count($files) - 1)]);
                $path = Storage::putFile('images', $file);
                $imageRecords->push([
                    'room_id' => $room->id,
                    'src' => $path,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ]);
            }
        }
        DB::table('images')->insert($imageRecords->toArray());

        $avatarRecords = collect([]);
        foreach ($users as $user) {
            for ($i = 0; $i < rand(0, count($avatars)); $i++) {
                $avatar = new File('storage/app/' . $avatars[rand(0, count($avatars) - 1)]);
                $path = Storage::putFile('avatars', $avatar);
                $avatarRecords->push([
                    'user_id' => $user->id,
                    'src' => $path,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ]);
            }
        }
        DB::table('avatars')->insert($avatarRecords->toArray());

        foreach ($rooms as $room) {
            for ($i = 0; $i < rand(0, 5); $i) {
                $randI = rand(0, count($users) - 1);
                if ($room->user_id !== $users[$randI]->id) {
                    $rateRecords->push(
                        [
                            'user_id' => $users[$randI]->id,
                            'room_id' => $room->id,
                            'point' => rand(1, 5),
                            'comment' => randStr(20),
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s"),
                        ]
                    );
                }
            }
        }
        DB::table('rates')->insert($rateRecords->toArray());
    }
}
