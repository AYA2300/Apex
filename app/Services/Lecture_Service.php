<?php
    namespace App\Services;

use App\Http\Trait\FileStorageTrait;
use App\Models\Lecture;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Console\View\Components\Secret;

    class Lecture_Service{

        use FileStorageTrait;

        public function add_Lecture(array $input_data){
            $data=[];
            $status_code=400;
            $msg='';
            $result=[];

            $Lecture=Lecture::create([
                'name' => $input_data['name'],
                'file' => $input_data['file'],
                'subject_id' => $input_data['subject_id'],
              
            ]);


            $msg = 'Lecture added successfully ';
            $data['Lecture']=$Lecture;
            $status_code = 200;

            $result =[
                'data' => $data,
                'status_code' => $status_code,
                'msg' => $msg,

            ];
            return $result;
        }

        public function get_Lectures(Subject $subject_id){
            $Lectures=Lecture::where('subject_id',$subject_id)->first();

          $msg = '';
          $data['Lectures']=$Lectures;
          $status_code = 200;

          $result =[
              'data' => $data,
              'status_code' => $status_code,
              'msg' => $msg,

          ];
          return $result;

        }


    }
?>
