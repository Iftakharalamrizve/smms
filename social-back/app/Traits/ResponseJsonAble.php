<?php
namespace App\Traits;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Response as Res;
use Response;

trait ResponseJsonAble{

    protected $statusCode = Res::HTTP_OK;
    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    /**
     * @param $message
     * @return json response
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }
    
    public function respondCreated($message, $data=null){
        return $this->respond([
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * @param Paginator $paginate
     * @param $data
     * @param $message
     *
     * @return mixed
     */
    protected function respondWithPagination(Paginator $paginate, $data, $message){

        return $this->respond([
            'status' => 'success',
            'status_code' => Res::HTTP_OK,
            'message' => $message,
            'data' => $data,
            'paginator' => [
                'total_count'  => $paginate->total(),
                'total_pages' => ceil($paginate->total() / $paginate->perPage()),
                'current_page' => $paginate->currentPage(),
                'limit' => $paginate->perPage(),
            ]
        ]);
    }
    
    public function respondNotFound($message = 'Not Found!'){
        return $this->respond([
            'status' => 'error',
            'status_code' => Res::HTTP_NOT_FOUND,
            'message' => $message,
        ]);
    }
    public function respondInternalError($message){
        return $this->respond([
            'status' => 'error',
            'status_code' => Res::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $message,
        ]);
    }
    public function respondValidationError($message, $errors){
        return $this->respond([
            'status' => 'error',
            'status_code' => Res::HTTP_UNPROCESSABLE_ENTITY,
            'message' => $message,
            'data' => $errors
        ]);
    }
    public function respondWithError($message){
        return $this->setStatusCode(401)->respond([
            'status' => 'error',
            'status_code' => Res::HTTP_UNAUTHORIZED,
            'message' => $message,
        ]);
    }

    public function respondWithToken($token,$user=NULL,$userType=null,$expiration=NULL)
    {
        return $this->respond([
            'access_token' => $token,
            'user' => $user,
            'user_type'=>$userType,
            'token_type' => 'bearer',
            'expires_in' => $expiration
        ]);
    }

    public function respond($data, $headers = []){
        return Response::json($data, $this->getStatusCode(), $headers);
    }


}