<?php

use Illuminate\Database\Seeder;
use App\Covid;

class CovidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [
                'Name'        => 'Ayesha Rahman',
                'Age'         => 24,
                'SEX'         => 'female',
                'Temperature' => 98.6,
                'Score'       => 0,
                'Result'      => 'Negative',
            ],
            [
                'Name'        => 'Karim Uddin',
                'Age'         => 45,
                'SEX'         => 'male',
                'Temperature' => 100.2,
                'Score'       => 3,
                'Result'      => 'Negative',
            ],
            [
                'Name'        => 'Tanvir Ahmed',
                'Age'         => 30,
                'SEX'         => 'male',
                'Temperature' => 99.8,
                'Score'       => 5,
                'Result'      => 'Positive',
            ],
            [
                'Name'        => 'Nusrat Jahan',
                'Age'         => 28,
                'SEX'         => 'female',
                'Temperature' => 101.1,
                'Score'       => 7,
                'Result'      => 'Positive',
            ],
            [
                'Name'        => 'Rafiq Hasan',
                'Age'         => 52,
                'SEX'         => 'male',
                'Temperature' => 103.0,
                'Score'       => 9,
                'Result'      => 'Positive',
            ],
        ];

        foreach ($records as $record) {
            Covid::create($record);
        }
    }
}
