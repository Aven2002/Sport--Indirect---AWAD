<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SecurityQuestion;

class SecurityQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            ['question' => 'What was the name of your first pet?'],
            ['question' => "What is your mother's name?"],
            ['question' => "What is your father's name?"],
            ['question' => 'What is your favorite music?'],
            ['question' => 'What is your favorite movie?'],
            ['question' => 'What is your favorite food?'],
            ['question' => 'What is your favorite sport?'],
            ['question' => 'What was the make and model of your first car?'],
            ['question' => 'What city were you born in?'],
            ['question' => 'What was your childhood nickname?'],
        ];

        foreach ($questions as $data) {
            SecurityQuestion::updateOrCreate(
                ['question' => $data['question']],  
            );
        }
    }
}
