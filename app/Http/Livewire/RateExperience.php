<?php

namespace App\Http\Livewire;

use WireElements\Pro\Components\Modal\Modal;

class RateExperience extends Modal
{
    public $selectedAreas = [];
    public $selectedFeedbackTypes = [];
    public $experience = '';
    public $feedback = '';

    protected $submitted = false;

    public function render()
    {
        return view('livewire.rate-experience', [
            'areas' => [
                'Idea Generation' => [
                    'Track Investors',
                    'Event Filings',
                    'Insider Transactions',
                    'Earnings Calendar',
                ],
                'Main Navigation' => [
                    'Overview',
                    'Financials',
                    'Analysis',
                    'Filings',
                    'Ownership',
                ],
            ],
            'feedbackTypes' => [
                'Visual Design' => '',
                'Experience' => '',
                'Data Quality' => '',
                'Loading Time' => '',
                'Others' => 'You can describe in the text field',
            ],
            'submitted' => $this->submitted,
        ]);
    }

    public function submit()
    {
        $this->validate([
            'selectedAreas' => ['nullable', 'array'],
            'selectedAreas.*' => ['required', 'string'],
            'selectedFeedbackTypes' => ['nullable', 'array'],
            'selectedFeedbackTypes.*' => ['required', 'string'],
            'experience' => ['required', 'in:bad,neutral,good'],
            'feedback' => ['nullable', 'string', 'max:2000'],
        ], [
            'experience.required' => 'Please select your experience',
            'feedback.max' => 'Your feedback should not exceed 2000 characters',
        ]);

        \App\Models\Feedback::create([
            'areas' => $this->selectedAreas,
            'feedback_types' => $this->selectedFeedbackTypes,
            'experience' => $this->experience,
            'feedback' => $this->feedback,
            'user_id' => auth()->id(),
        ]);

        $this->reset('selectedAreas', 'selectedFeedbackTypes', 'experience', 'feedback');

        $this->submitted = true;
    }
}
