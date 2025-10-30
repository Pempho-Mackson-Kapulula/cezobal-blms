<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Division;
use App\Services\SchedulerService;
use Illuminate\Support\Facades\Log;

class ScheduleGenerator extends Component
{
    public $divisions = [];
    public $selectedDivision = null;
    public $message = null;

    public function mount()
    {
        // Load all divisions
        $this->divisions = Division::orderBy('name')->get();
    }

    public function generateSchedule()
    {
        if (!$this->selectedDivision) {
            $this->message = '⚠ Please select a division before generating.';
            return;
        }

        $scheduler = new SchedulerService();

        try {
            // Generate schedule for this single division
            $success = $scheduler->generateForDivision($this->selectedDivision);

            if ($success) {
                $this->message = "Schedule successfully generated";
            } else {
                $this->message = "⚠ Could not generate schedule — check if the division has enough teams.";
               
            }

        } catch (\Exception $e) {
            $this->message = '❌ Error: ' . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.admin.schedule-generator');
    }
}
