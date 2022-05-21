<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('subscriptions')->insert([
                ['id' => Str::uuid(), 'name' => 'basic'],
                ['id' => Str::uuid(), 'name' => 'standard'],
                ['id' => Str::uuid(), 'name' => 'premium']
            ]
        );

        $sobscriptionId = (Subscription::first())->id;

        DB::table('users')->insert([
            ['id' => Str::uuid(), 'email' => 'admin@dxmusic.nl', 'password' => Hash::make('BRkuT2awqENoNMpo'), 'subscription_id' => $sobscriptionId, 'role' => \App\Models\User::USER_ROLE_ADMIN],
            ['id' => Str::uuid(), 'email' => 'partner@dxmusic.nl', 'password' => Hash::make('OnGuEegw36dmUfp1'), 'subscription_id' => $sobscriptionId, 'role' => \App\Models\User::USER_ROLE_USER],
            ['id' => Str::uuid(), 'email' => 'device@dxmusic.nl', 'password' => Hash::make('i5ETv8ifePTq4mr2'), 'subscription_id' => $sobscriptionId, 'role' => \App\Models\User::USER_ROLE_USER]
        ]);
    }
}
