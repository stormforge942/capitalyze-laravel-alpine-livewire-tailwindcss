<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'areas' => $this->faker->randomElements([
                'Idea Generation > Track Investors',
                'Idea Generation > Event Filings',
                'Idea Generation > Insider Transactions',
                'Idea Generation > Earnings Calendar',
                'Main Navigation > Overview',
                'Main Navigation > Financials',
                'Main Navigation > Analysis',
                'Main Navigation > Filings',
                'Main Navigation > Ownership',
            ], random_int(2, 8)),
            'feedback_types' => $this->faker->randomElements([
                'Visual Design',
                'Experience',
                'Data Quality',
                'Loading Time',
                'Others',
            ], random_int(1, 3)),
            'experience' => $this->faker->randomElement(['bad', 'neutral', 'good']),
            'feedback' => $this->faker->paragraph(),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
