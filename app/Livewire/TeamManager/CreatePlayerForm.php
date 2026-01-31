<?php

namespace App\Livewire\TeamManager;

use App\Models\Player;
use App\Models\Team;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Exception;

#[Layout('components.layouts.app')]
class CreatePlayerForm extends Component
{
    use WithFileUploads;

    public $teamId;
    public $bio; // Property for the new bio field
    public string $name = '';
    public ?string $position = null;
    public ?int $jersey_number = null;
    public ?string $date_of_birth = null;
    public $photo_path;

    const MAX_PLAYERS = 15;

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'position' => 'required|string|min:2|max:255',
            'bio' => 'nullable|string|max:1000', // Added validation for bio
            'jersey_number' => [
                'required',
                'integer',
                'min:0',
                'max:99',
                function ($attribute, $value, $fail) {
                    $exists = Player::where('team_id', $this->teamId)
                        ->where('jersey_number', $value)
                        ->exists();

                    if ($exists) {
                        $fail("Jersey #{$value} is already assigned to another player on this team.");
                    }
                },
            ],
            'date_of_birth' => 'nullable|date',
            'photo_path' => 'nullable|image|max:2048',
        ];
    }

    public function mount($teamId)
    {
        $this->teamId = $teamId;
    }

    public function createPlayer()
    {
        $currentCount = Player::where('team_id', $this->teamId)->count();

        if ($currentCount >= self::MAX_PLAYERS) {
            session()->flash('error', 'Roster Full: You cannot register more than ' . self::MAX_PLAYERS . ' players.');
            return;
        }

        $this->validate();

        try {
            $photoPath = $this->photo_path
                ? $this->photo_path->store('players', 'public')
                : null;

            Player::create([
                'team_id' => $this->teamId,
                'name' => strtoupper($this->name),
                'position' => $this->position,
                'jersey_number' => $this->jersey_number,
                'date_of_birth' => $this->date_of_birth,
                'bio' => $this->bio, // Persist the bio to the database
                'photo_path' => $photoPath,
            ]);

            session()->flash('message', 'Athlete added to roster successfully.');

            return $this->redirect(route('team-manager.dashboard'), navigate: true);

        } catch (Exception $e) {
            session()->flash('error', 'Critical System Failure: Player could not be registered.');
        }
    }

    public function render()
    {
        return view('livewire.team-manager.create-player-form', [
            'currentCount' => Player::where('team_id', $this->teamId)->count()
        ]);
    }
}
