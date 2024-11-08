<?php

namespace App\Http\Controllers;

use App\Http\Requests\add_lectureRequest;
use App\Http\Trait\ApiResponseTrait;
use App\Models\Subject;
use App\Services\Lecture_Service;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    use ApiResponseTrait;
    public function __construct(protected Lecture_Service $lecture_Service)
    {

    }

    public function add_lecture(add_lectureRequest $request){
        $input_data=$request->validated();
        $result=$this->lecture_Service->Add_lecture($input_data);
        $output=[];
        if ($result['status_code'] == 200) {
            $result_data = $result['data'];
            // response data preparation:

            $output['lecture']=$result_data['lecture'];


    }
    return $this->send_response($output, $result['msg'], $result['status_code']);

}

public function get_lectures(Subject $subject_id){

    $result=$this->lecture_Service->get_lectures($subject_id);
    $output=[];
    if ($result['status_code'] == 200) {
        $result_data = $result['data'];
        // response data preparation:

        $output['lectures']=$result_data['lectures'];


}
return $this->send_response($output, $result['msg'], $result['status_code']);

}
}


