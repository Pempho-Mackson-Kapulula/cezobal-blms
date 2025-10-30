<?php

namespace App\Livewire\TeamManager;

use App\Models\Player;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads; // Import WithFileUploads
use Exception;

#[Layout('components.layouts.app')]
class CreatePlayerForm extends Component
{
    use WithFileUploads; // Use the trait

    public $teamId;
    public string $name = '';
    public ?string $position = null;
    public ?int $jersey_number = null;
    public ?string $date_of_birth = null;
    public ?\Illuminate\Http\UploadedFile $photo_path = null; // Update the property type

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'position' => 'required|string|min:2|max:255',
            'jersey_number' => 'nullable|integer|min:0',
            'date_of_birth' => 'nullable|date',
            'photo_path' => 'nullable|image|max:2048', // Add validation for the photo
        ];
    }
    
    public function mount($teamId)
    {
        $this->teamId = $teamId;
    }

    public function createPlayer()
    {
        $this->validate();

        try {
            $photoPath = $this->photo_path ? $this->photo_path->store('players', 'public') : null;

            Player::create([
                'team_id' => $this->teamId,
                'name' => $this->name,
                'position' => $this->position,
                'jersey_number' => $this->jersey_number,
                'date_of_birth' => $this->date_of_birth,
                'photo_path' => $photoPath,
            ]);

            session()->flash('message', 'Player created successfully.');
            
            $this->redirect(route('team-manager.dashboard'), navigate: true);
        } catch (Exception $e) {
            session()->flash('error', 'An error occurred while creating the player. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.team-manager.create-player-form');
    }
}
