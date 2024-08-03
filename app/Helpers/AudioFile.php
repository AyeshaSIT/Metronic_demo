<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use App\Models\AudioCall;
class AudioFile
{
    public function SaveAudioRecord($data)
    {
    
        DB::beginTransaction();
        try {
            $audiorecord =AudioCall::create($data);
            DB::commit();
            return  $audiorecord;
            
        } catch (\Exception $ex) {
            DB::rollBack();
        }
    
    }
    public function ViewAudioRecord()
    {
        $audioview=AudioCall::all();
        return $audioview;
    }
    public function DeleteAudioRecord($id)
    {
        $audiodelete = AudioCall::find($id); //found record
        $status=FALSE;
        DB::beginTransaction();
            try {
                // Construct the full file path to the audio file
                $audio_path = public_path("storage/").$audiodelete->file_path;
                if(file_exists($audio_path)){
                    @unlink($audio_path);
                }
                $audiodelete->delete(); //delete file from db
                DB::commit();
                $status=TRUE;
                return $status;
                
                 
            } catch (\Exception $ex) {
                DB::rollBack();
                $status=False;
                return $status;
               
               
            }

    }

}

?>