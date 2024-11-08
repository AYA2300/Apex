<?php

namespace App\Http\Controllers;

use App\Http\Requests\add_SubjectRequest;
use App\Http\Requests\SubjectRequest;
use App\Http\Trait\ApiResponseTrait;
use App\Models\Section;
use App\Models\Subject;
use App\Services\Subject_Service;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class SubjectController extends Controller

    {
        use ApiResponseTrait;
        public function __construct(protected Subject_Service $Subject_Service)
        {

        }

        public function add_Subject(add_SubjectRequest $request){
            $input_data=$request->validated();
            $result=$this->Subject_Service->Add_Subject($input_data);
            $output=[];
            if ($result['status_code'] == 200) {
                $result_data = $result['data'];
                // response data preparation:

                $output['subject']=$result_data['subject'];


        }
        return $this->send_response($output, $result['msg'], $result['status_code']);

    }


    public function getSubjects(Request $request)
    {
        // تحقق من أن جميع الفلاتر المطلوبة موجودة
        $validatedData = $request->validate([
            'year' => 'required|integer',
            'chapter' => 'required|string',
            'type' => 'required|string',
            'section_id' => 'required_if:year,4,5|string'  // القسم مطلوب فقط للسنة الرابعة والخامسة
        ]);

        // فلترة بناءً على السنة، الفصل والنوع
        $subjects = Subject::where('year', $request->year)
            ->where('chapter', $request->chapter)
            ->where('type', $request->type);

        // فلترة القسم للسنة الرابعة والخامسة
        if (in_array($request->year, [4, 5])) {
            $subjects = $subjects->where('section_id', $request->section_id);
        }

        // الحصول على النتائج النهائية
        $subjects = $subjects->get();

        // تحقق مما إذا كانت النتيجة فارغة
        if ($subjects->isEmpty()) {
            return response()->json([
                'message' => 'Subject not found'
            ], 404);
        }

        // تحويل المجموعات إلى مصفوفة وإرجاعها
        return response()->json($subjects->values());
    }



}
