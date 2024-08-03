<?php

namespace App\Livewire\AudioCall;

use Livewire\Component;
use Livewire\WithFileUploads;
use session;
use App\Models\User;
use App\Models\CallUser;
use App\Models\AudioCall;
use App\Helpers\AudioFile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\JobsProcessed;
use App\Jobs\ProcessAudioCall;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ViewErrorBag;
use App\DataTables\AudioCallDataTable;
use App\DataTables\CallUsersDataTable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class AddAudioCallModal extends Component
{
    

    // public function __construct(AudioFile $audioFile)
    // {
    //     $this->audioFile = $audioFile;
    // }
    use WithFileUploads;

    public $audiocall_id;
    public $name;
    public $file;
    public $language;
    public $create_by;
    public $updated_by;
    protected $audioFile;

    public $edit_mode = false;
    
    //  Define validation rules
    // protected $rules = [
    //     'name' => 'required|string',
    //     // 'file' => 'required|mimes:audio/mpeg,mpga,mp3,wav,aac|max:10240',
    //     'language' => 'required',
    //     'create_by' => 'required',
    //     'updated_by' => 'required',
    // ];
    protected $listeners = [
        'delete_user' => 'deleteAudioCall',
        'update_user' => 'updateAudioCall',
        'new_user' => 'hydrate',
    ];
    public function mount(AudioFile $audioFile)
    {
        $this->audioFile = $audioFile; // Initialize the AudioFile instance
    }

    public function render()
    {
        return view('livewire.audio-call.add-audio-call-modal');
    }

    // public function submit(Request $request)
    // {
    //     // Validate the form input data
    //     // $this->validate();
    //     $userid = Auth::id();
    //     // $filed = $this->file('file');
    //     // $uniqueId = (string) Str::uuid();
    //     // $filename = $uniqueId.'.'.$filed->getClientOriginalExtension();
    //     // $file_path= "audio/$filename"; 
    //     $data =[
    //         'name' =>  $request->name,
    //         // 'file_path'=> $file_path,
    //         'language' =>  $request->language,
    //         'create_by' => $userid,
    //         'updated_by' => $userid,
    //     ];

    //        // Update or Create a new user record in the database
    //      // Save the audio file to the storage
    //     //  $filed->storeAs('audio', $filename, 'public');   
    //     //     // $user = CallUser::find($this->calluser_id) ?? CallUser::create($data);
    //         if (is_null($this->audioFile)) {
    //             $this->audioFile = new AudioFile();
    //         }
    //     $audioc=$this->audioFile->SaveAudioRecord($data);

    //         if ($audioc) {
    //             // Emit a success event with a message
    //             $this->dispatch('success', __('User updated'));
    //         } else {

    //             // Emit a success event with a message
    //             $this->dispatch('success', __('No created'));
    //         }

    //     // Reset the form fields after successful submission
    //     $this->reset();
    // }

    public function submit()
    {
        // Validate the form input data
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'file' => 'required|file|mimes:mpeg,mpga,mp3,wav,aac', 
        ]);

        $userid = Auth::id();

        // Handle file upload
        if ($this->file) {
            $uniqueId = (string) Str::uuid();
            $filename = $uniqueId . '.' . $this->file->getClientOriginalExtension();
            $file_path = "audio/$filename";
            
            // Save the audio file to the storage
            $this->file->storeAs('audio', $filename, 'public');
        } else {
            // Handle the case where the file is not uploaded
            $this->dispatch('error', 'File upload failed.');
            return;
        }

        // Prepare data for saving
        $data = [
            'name' => $validatedData['name'],
            'file_path' => $file_path,
            'language' => $validatedData['language'],
            'create_by' => $userid,
            'updated_by' => $userid,
        ];

        // Update or create a new audio record in the database
        if (is_null($this->audioFile)) {
            $this->audioFile = new AudioFile();
        }
        $audioc = $this->audioFile->SaveAudioRecord($data);

        if ($audioc) {
            // Reset the form fields after successful submission
            $this->reset();
            $jobprocess = JobsProcessed::create([
                'audiocall_id' => $audioc['id'],
                'user_id' => $userid,
                'status' =>  Config::get('mappings.statuses.pending'),

            ]);
            
            ProcessAudioCall::dispatch($jobprocess);
            // Handle success (e.g., redirect or return a response)
            $this->dispatch('success', 'Audio file uploaded successfully.');
        } else {
            // Handle failure (e.g., return an error response)
            $this->dispatch('error', 'Failed to save audio record.');
        }
    }

 
    public function deleteAudioCall($id)
    {
        if (is_null($this->audioFile)) {
            $this->audioFile = new AudioFile();
        }
        $recorddel=$this->audioFile->DeleteAudioRecord($id);
        if ($recorddel) {
            $this->dispatch('success', 'User sucessfully deleted');
        } else {
            $this->dispatch('error', 'User not deleted');
        }
    }
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        // $this->reset();
    }

}
