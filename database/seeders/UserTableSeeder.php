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
                'jurusan' => 'PPLG',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Kaprog TJKT',
                'email' => 'kaprogtjkt@gmail.com',
                'password' => bcrypt('kaprogtjkt'),
                'jurusan' => 'TJKT',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Kaprog DKV',
                'email' => 'kaprogdkv@gmail.com',
                'password' => bcrypt('kaprogdkv'),
                'jurusan' => 'DKV',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Kaprog MPLB',
                'email' => 'kaprogmplb@gmail.com',
                'password' => bcrypt('kaprogmplb'),
                'jurusan' => 'MPLB',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Kaprog PMN',
                'email' => 'kaprogpmn@gmail.com',
                'password' => bcrypt('kaprogpmn'),
                'jurusan' => 'PMN',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Kaprog KLN',
                'email' => 'kaprogkln@gmail.com',
                'password' => bcrypt('kaprogkln'),
                'jurusan' => 'DKV',
                'email_verified_at' => now()
            ],
            [
                'name' => 'Kaprog HTL',
                'email' => 'kaproghtl@gmail.com',
                'password' => bcrypt('kaproghtl'),
                'jurusan' => 'HTL',
                'email_verified_at' => now()
            ],
        ];

        foreach ($kaprogs as $kaprog) {
            User::create($kaprog);
        }
    }
}
