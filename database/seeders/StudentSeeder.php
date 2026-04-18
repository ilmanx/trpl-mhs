<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // class pembuatan data dummy berdasarkan regional Indonesia
        $faker = \Faker\Factory::create('id_ID');

        // lakukan pengulangan untuk penambahan data ke database
        for ($i = 0; $i < 10; $i++) {
            Student::create([
                'nim'            => $faker->unique()->numerify('##########'),
                'nama'           => $faker->name(),
                'prodi'          => $faker->randomElement(['TRM', 'TRMK', 'IL', 'TRPL']),
                'tanggal_lahir'  => $faker->date(),
                'email'          => $faker->unique()->safeEmail(),
                'alamat'         => $faker->address(),
            ]);
        }
    }
}
