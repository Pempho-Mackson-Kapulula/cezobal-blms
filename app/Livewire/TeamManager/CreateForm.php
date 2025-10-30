<?php

namespace App\Livewire\TeamManager;

use App\Models\Division;
use App\Models\Team;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Exception;

class CreateForm extends Component
{
    use WithFileUploads;

    public string $name = '';
    public ?string $coach_name = null;
    public ?string $bio = null;
    public ?int $division_id = null;
    public ?UploadedFile $logo_path = null;

    public function createTeam()
    {
        $this->validate([
            'name' => 'required|string|min:3|max:255|unique:teams,name',
            'coach_name' => 'nullable|string|min:3|max:255',
            'bio' => 'nullable|string|max:1000',
            'division_id' => 'required|integer|exists:divisions,id',
            'logo_path' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        try {
            if ($user->team) {
                // This check is now redundant if the parent handles the conditional rendering,
                // but kept for safety.
                session()->flash('error', 'You have already created a team.');
                return;
            }

            $logoPath = $this->logo_path ? $this->logo_path->store('teams', 'public') : null;

            Team::create([
                'team_manager_id' => $user->id,
                'division_id' => $this->division_id,
                'name' => $this->name,
                'coach_name' => $this->coach_name,
                'bio' => $this->bio,
                'logo_path' => $logoPath,
            ]);

            session()->flash('message', 'Team created successfully.');

            // Emit an event to notify the parent component that a new team was created.
            $this->dispatch('team-created');
        } catch (Exception $e) {
            logger()->error('Team creation failed: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'form_data' => $this->all(),
            ]);
            session()->flash('error', 'An error occurred while creating the team. Please try again.');
        }
    }

    public function getDivisionsProperty()
    {
        return Division::all();
    }

    public function render()
    {
        return view('livewire.team-manager.create-form');
    }
}
