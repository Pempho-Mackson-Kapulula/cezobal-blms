<?php

namespace App\Livewire\TeamManager;

use App\Models\Division;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateForm extends Component
{
    use WithFileUploads;

    public string $name = '';
    public ?string $coach_name = '';
    public ?string $bio = '';
    public ?int $division_id = null;
    public $logo_path;

    protected $rules = [
        'name' => 'required|string|min:3|max:255|unique:teams,name',
        'coach_name' => 'nullable|string|min:3|max:255',
        'bio' => 'nullable|string|max:1000',
        'division_id' => 'required|exists:divisions,id',
        'logo_path' => 'nullable|image|max:2048',
    ];

    public function createTeam()
    {
        // This will now throw an exception if validation fails, 
        // which helps in identifying hidden issues.
        $this->validate();

        $user = Auth::user();

        if (!$user || $user->team) {
            session()->flash('error', 'Unauthorized or team already exists.');
            return;
        }

        try {
            $logoUrl = $this->logo_path
                ? $this->logo_path->store('teams', 'public')
                : null;

            Team::create([
                'team_manager_id' => $user->id,
                'division_id' => $this->division_id,
                'name' => $this->name,
                'coach_name' => $this->coach_name,
                'bio' => $this->bio,
                'logo_path' => $logoUrl,
                'home_court_id' => 1,
            ]);

            session()->flash('message', 'Team created successfully!');
            return redirect()->route('team-manager.dashboard');

        } catch (\Exception $e) {
            // Log the error for you to see in the browser if it fails
            session()->flash('error', 'System Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.team-manager.create-form', [
            'divisions' => Division::all()
        ]);
    }
}