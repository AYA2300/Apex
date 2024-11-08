<?php
namespace App\Http\Trait;

trait ApiResponseTrait{

        /**
     * Generate custom API response.
     *
     * This method generates a JSON response for API requests. It supports paginated data
     * and includes pagination details if the provided data is an instance of
     * \Illuminate\Pagination\LengthAwarePaginator.
     *
     * @param  mixed  $data    The response data. It can be any data type.
     * @param  string $message A message describing the response.
     * @param  int    $status_code  The HTTP status code for the response.
     * @return \Illuminate\Http\JsonResponse The API response in JSON format.
     */


    public function send_response(mixed $data=null, string $message='success', int $status_code=200)
    {
        $success_state = $status_code == 200 ? true : false;
        if(!is_null($data)){

                    $response = [
                        'success'   => $success_state,
                        'data'      => $data,
                        'message'   => $message
                    ];

        }

        return response()->json($response, $status_code);
    }

}
?>
