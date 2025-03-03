<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kaprogs = [
            [
                'name' => 'Kaprog PPLG',
                'email' => 'kaprogpplg@gmail.com',
                'password' => bcrypt('kaprogpplg'),
                'jurusan_id' => '1',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Kaprog TJKT',
                'email' => 'kaprogtjkt@gmail.com',
                'password' => bcrypt('kaprogtjkt'),
                'jurusan_id' => '3',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Kaprog DKV',
                'email' => 'kaprogdkv@gmail.com',
                'password' => bcrypt('kaprogdkv'),
                'jurusan_id' => '2',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Kaprog MPLB',
                'email' => 'kaprogmplb@gmail.com',
                'password' => bcrypt('kaprogmplb'),
                'jurusan_id' => '4',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Kaprog PMN',
                'email' => 'kaprogpmn@gmail.com',
                'password' => bcrypt('kaprogpmn'),
                'jurusan_id' => '5',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Kaprog KLN',
                'email' => 'kaprogkln@gmail.com',
                'password' => bcrypt('kaprogkln'),
                'jurusan_id' => '6',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Kaprog HTL',
                'email' => 'kaproghtl@gmail.com',
                'password' => bcrypt('kaproghtl'),
                'jurusan_id' => '7',
                'email_verified_at' => now()
            ],
        ];

        foreach ($kaprogs as $kaprog) {
            User::create($kaprog);
        }
    }
}
