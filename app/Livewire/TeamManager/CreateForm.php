<?php

namespace App\Livewire\TeamManager;

use App\Models\Division;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;

class CreateForm extends Component
{
    use WithFileUploads;

    public string $name = '';
    public ?string $coach_name = null;
    public ?string $bio = null;
    public ?int $division_id = null;
    public ?UploadedFile $logo_path = null;
    public $divisions;

    public function mount()
    {
        // Load divisions for the select dropdown
        $this->divisions = Division::all();
    }

    public function createTeam()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|min:3|max:255|unique:teams,name',
            'coach_name' => 'nullable|string|min:3|max:255',
            'bio' => 'nullable|string|max:1000',
            'division_id' => 'required|integer|exists:divisions,id',
            'logo_path' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        if (!$user) {
            session()->flash('error', 'You must be logged in to create a team.');
            return;
        }

        if ($user->team) {
            session()->flash('error', 'You already have a team.');
            return;
        }

        try {
            $logoPath = $this->logo_path ? $this->logo_path->store('teams', 'public') : null;

            Team::create([
                'team_manager_id' => $user->id,
                'division_id' => $validatedData['division_id'],
                'name' => $validatedData['name'],
                'coach_name' => $validatedData['coach_name'] ?? null,
                'bio' => $validatedData['bio'] ?? null,
                'logo_path' => $logoPath,
                'home_court_id' => 1, // Temp default, replace with real selection later
            ]);

            session()->flash('message', 'Team created successfully.');
            $this->dispatch('team-created');
        } catch (\Exception $e) {
            logger()->error('Team creation failed: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'validatedData' => $validatedData,
            ]);

            session()->flash('error', 'Error creating team: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.team-manager.create-form');
    }
}
