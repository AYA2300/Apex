<?php

namespace App\Http\Controllers;

use App\Http\Requests\add_SectionRequest;
use App\Http\Trait\ApiResponseTrait;
use App\Services\Section_Service;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    use ApiResponseTrait;
    public function __construct(protected Section_Service $Section_Service)
    {

    }

    public function add_Section(add_SectionRequest $request){
        $input_data=$request->validated();
        $result=$this->Section_Service->Add_Section($input_data);
        $output=[];
        if ($result['status_code'] == 200) {
            $result_data = $result['data'];
            // response data preparation:

            $output['section']=$result_data['section'];


    }
    return $this->send_response($output, $result['msg'], $result['status_code']);

}

public function get_Section(){

    $result=$this->Section_Service->get_Sections();
    $output=[];
    if ($result['status_code'] == 200) {
        $result_data = $result['data'];
        // response data preparation:

        $output['sections']=$result_data['sections'];


}
return $this->send_response($output, $result['msg'], $result['status_code']);

}
}
