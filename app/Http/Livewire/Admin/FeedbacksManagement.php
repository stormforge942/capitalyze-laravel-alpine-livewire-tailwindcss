<?php

namespace App\Http\Livewire\Admin;

use App\Models\Feedback;
use Livewire\Component;
use Livewire\WithPagination;

class FeedbacksManagement extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.feedbacks-management', [
            'feedbacks' => Feedback::query()
                ->latest()
                ->with('user')
                ->paginate(20),
        ]);
    }

    public function deleteFeedback(Feedback $feedback) {
        $feedback->delete();
    }
}
