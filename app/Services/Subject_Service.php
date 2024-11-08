<?php
    namespace App\Services;

use App\Http\Trait\FileStorageTrait;
use App\Models\subject;
use App\Models\Section;
use Illuminate\Console\View\Components\Secret;

    class Subject_Service{

        use FileStorageTrait;

        public function add_subject(array $input_data){
            $data=[];
            $status_code=400;
            $msg='';
            $result=[];

            $subject=Subject::create([
                'name' => $input_data['name'],
                'description' => $input_data['description'],
                'image' => $this->storeFile($input_data['image'],'subjects'),
                'year' => $input_data['year'],
                'chapter' => $input_data['chapter'],
                'section_id' => $input_data['section_id'],
                'type' => $input_data['type'],

            ]);


            $msg = 'subject added successfully';
            $data['subject']=$subject;
            $status_code = 200;

            $result =[
                'data' => $data,
                'status_code' => $status_code,
                'msg' => $msg,

            ];
            return $result;
        }

        public function get_subjects($input_data){
            if($input_data!=null){
                $subject=$input_data['section_id']->subjects()->get();

            }

          $msg = 'المواد';
          $data['subjects']=$subject;
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
