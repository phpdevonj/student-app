<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        // \App\Models\User::factory(10)->create();

        $user = User::where(['email' => 'admin@gmail.com'])->first();

        if (!$user) {
            User::factory()->create([
                'name' => 'Admin',
                'middle_name' => 'admin',
                'last_name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$10$XCVcaeQCGpeCJa1W0iU8eOdFIMDSuGCweykQMvSx59VuFwTFfyAP.', // qwQW12!@
                'type' => User::admin
            ]);
        }
    }
}
