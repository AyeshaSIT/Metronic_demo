<?php

namespace App\Livewire\CallUser;

use Livewire\Component;
use App\Models\CallUser;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AddCallUserModal extends Component
{

    use WithFileUploads;

    public $calluser_id;
    public $name;
    public $usertype;
    public $avatar;
    public $saved_avatar;

    public $edit_mode = false;

    protected $rules = [
        'name' => 'required|string',
        'usertype' => 'required',
        'avatar' => 'nullable|sometimes|image|max:1024',
    ];

    protected $listeners = [
        'delete_user' => 'deleteCallUser',
        'update_user' => 'updateCallUser',
        'new_user' => 'hydrate',
    ];

    public function render()
    {
        $usertypes = config('mappings.call_usertypes');
        $usertypes_with_description = collect($usertypes)->map(function ($details, $type) {
            return [
                'type' => $type,
                'value' => $details['value'],
                'description' => $details['description'],
            ];
        });
    
        return view('livewire.call-user.add-call-user-modal', ['usertypes' => $usertypes_with_description]);
    }
    

    public function submit()
    {
        // Validate the form input data
        $this->validate();

        DB::transaction(function () {
            // Prepare the data for creating a new user
            $usertypes = config('mappings.call_usertypes');
            $usertypeValue = $usertypes[$this->usertype]['value'];

            $data = [
                'name' => $this->name,
                'type' => $usertypeValue,
            ];

            if ($this->avatar) {
                $data['profile_photo_path'] = $this->avatar->store('avatars', 'public');
            } else {
                $data['profile_photo_path'] = null;
            }

           
            // Update or Create a new user record in the database
            
            $user = CallUser::find($this->calluser_id) ?? CallUser::create($data);

            if ($this->edit_mode) {
                foreach ($data as $k => $v) {
                    $user->$k = $v;
                }
                $user->save();
            }

            if ($this->edit_mode) {
                

                // Emit a success event with a message
                $this->dispatch('success', __('User updated'));
            } else {

                // Emit a success event with a message
                $this->dispatch('success', __('New user created'));
            }
        });

        // Reset the form fields after successful submission
        $this->reset();
    }

    public function deleteCallUser($id)
    {

        // Delete the user record with the specified ID
        CallUser::destroy($id);

        // Emit a success event with a message
        $this->dispatch('success', 'User successfully deleted');
    }

    public function updateCallUser($id)
    {
        $this->edit_mode = true;

        $user = CallUser::find($id);

        $this->calluser_id = $user->id;
        $this->saved_avatar = $user->profile_photo_url;
        $this->name = $user->name;
        $usertypes = config('mappings.call_usertypes');
        $this->usertype = collect($usertypes)->filter(function ($details) use ($user) {
            return $details['value'] == $user->type;
        })->keys()->first();
        
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        // $this->reset();
    }
}
