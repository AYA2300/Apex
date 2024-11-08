<?php
    namespace App\Services;

use App\Http\Trait\FileStorageTrait;
use App\Models\Section;
use Illuminate\Console\View\Components\Secret;

    class Section_Service{

        use FileStorageTrait;

        public function add_section(array $input_data){
            $data=[];
            $status_code=400;
            $msg='';
            $result=[];

            $section=Section::create([
                'name' => $input_data['name'],
            ]);


            $msg = 'section added successfully ';
            $data['section']=$section;
            $status_code = 200;

            $result =[
                'data' => $data,
                'status_code' => $status_code,
                'msg' => $msg,

            ];
            return $result;
        }

        public function get_sections(){

      
         $sections=Section::get();

          $msg = '';
          $data['sections']=$sections;
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
