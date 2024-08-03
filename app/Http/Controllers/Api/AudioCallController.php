<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\AudioCall;
use App\Helpers\AudioFile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\JobsProcessed;
use App\Jobs\ProcessAudioCall;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Storage\AwsS3Adapter;
use Illuminate\Support\Facades\Validator;

class AudioCallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $audioFile;

    public function __construct(AudioFile $audioFile)
    {
        $this->audioFile = $audioFile;
    }
    public function index()
    {
        $audiocalls=$this->audioFile->ViewAudioRecord();
        if(count($audiocalls)>0){
            //data exists
            $response = [
                'message'=> count($audiocalls).' Record found',
                'status'=>1,
                'data'=>$audiocalls,
            ];

        }
        else{
            $response = [
                'message'=> count($audiocalls).' Record found',
                'status'=>0
            ];
        }
        return response()->json($response,200);

    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $errmessages = [
            'file.max' => 'The audio may not be greater than 10 MB.',
        ];
        $validation_rules = Validator::make($request->all(), [
            'name'=>'required|string',
            'file' => 'required|mimes:audio/mpeg,mpga,mp3,wav,aac|max:10240', // example validation rule
            'language'=>'required|string',
        ],$errmessages);
       
        if ($validation_rules->fails()) {
            return response()->json($validation_rules->messages());
        }
        else{
                $filed = $request->file('file');
                $uniqueId = (string) Str::uuid();
                $filename = $uniqueId.'.'.$filed->getClientOriginalExtension();
                //The below path take us to storage/app,write public to put it in public folder rather than local which is default
                $path=  $filed->storeAs('callinsights/audio',$filename,'s3'); 
                $data =['name' => $request->name,
                        'file_path'=>$path,
                        'language' => $request->language,
                        'create_by' => $request->create_by,
                        'updated_by' => $request->updated_by,
                       ];
                 // Generate the URL for the stored file
                //  $url = Storage::disk('s3')->url($path);
                       //send data to the function
                $audioc=$this->audioFile->SaveAudioRecord($data);
                if($audioc){   
                   
                    $jobprocess = JobsProcessed::create([
                        'audiocall_id' => $audioc['id'],
                        'user_id' => $audioc['create_by'],
                        'status' =>  Config::get('mappings.statuses.pending'),
        
                    ]);
                    
                    ProcessAudioCall::dispatch($jobprocess);          
                    return response()->json(['message' => 'Data Uploaded Successfully','path'=>$path,'data'=>$audioc],200);} 
                else {
                return response()->json(['message' => 'Error Uploading file'], 500);
                }
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
       
        if(!$recorddel){
                $response = [
                    'message'=>"Record doesn't exists",
                    'status' => 0
                ];
                $respcode=404;
        }
        else{
            try {
                $response = [
                    'message'=>"Record deleted sucessfully",
                    'status' => 1
                ];
                $respcode=200;
                 
            } catch (\Exception $ex) {
                $response = [
                    'message'=>"Error while deleting",
                    'status' => 0,
                ];
               
            }

        }
        return response()->json($response, $respcode);
       
    }
}
?>