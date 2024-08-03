<?php

namespace App\Http\Controllers;
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

class FrontendAudioCallController extends Controller
{
    protected $audioFile;

    public function __construct(AudioFile $audioFile)
    {
        $this->audioFile = $audioFile;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(AudioCallDataTable $dataTable)
    {
        // $audiocalls=$this->audioFile->ViewAudioRecord();
        // return view('audiocalls.index', compact('audiocalls'));
        return $dataTable->render('pages/call-insights.data-management.audiocalls.list');
    }


    public function create()
    {
        $errors = session()->get('errors') ?: new ViewErrorBag();
        
        return view('audiocalls.create')->with('errors', $errors);;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $errmessages = [
            // 'name' => 'The name field is required.',
            'file.max' => 'The audio may not be greater than 10 MB.',
        
        ];
        //  Define validation rules
         $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'file' => 'required|mimes:audio/mpeg,mpga,mp3,wav,aac|max:10240', //100MB
            'language' => 'required|string',
        ],$errmessages);

        if ($validator->fails()) {
            return redirect()->route('call-insights.f-audiocalls.create')
                             ->withErrors($validator)
                             ->withInput();
        }
        $userid = Auth::id();
        $filed = $request->file('file');
        $uniqueId = (string) Str::uuid();
        $filename = $uniqueId.'.'.$filed->getClientOriginalExtension();
        $path= "audio/$filename"; 
        $data =[
            'name' => $request->name,
            'file_path'=> $path,
            'language' => $request->language,
            'create_by' => $userid,
            'updated_by' => $userid,
        ];
        
        $audioc=$this->audioFile->SaveAudioRecord($data);
        if ($audioc) {
            $filed->storeAs('audio',$filename,'public');
            $jobprocess = JobsProcessed::create([
                'audiocall_id' => $audioc['id'],
                'user_id' => $userid,
                'status' =>  Config::get('mappings.statuses.pending'),

            ]);
            
            ProcessAudioCall::dispatch($jobprocess);


            return redirect()->route('call-insights.f-audiocalls.create')->with('success', 'Record uploaded successfully!');
            
        } else {
            return redirect()->route('call-insights.f-audiocalls.create')->with('error', 'Failed to upload record. Please try again.');
        }
    }



    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = AudioCall::find($id);
        return view('pages/call-insights.data-management.audiocalls.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {    
        $recorddel=$this->audioFile->DeleteAudioRecord($id);
        if ($recorddel) {
            return redirect()->route('call-insights.f-audiocalls.index')->with('success', 'deleted successfully');
        } else {
            return redirect()->route('call-insights.f-audiocalls.index')->with('error', 'error');
        }

    }

}
