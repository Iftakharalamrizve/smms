<?php
namespace App\Services;

use App\Repositories\WebHookRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WebHookService
{
    protected $webHookRepository;

    public function __construct()
    {

        $this->webHookRepository = new WebHookRepository;

    }


    public function listItems($request = null)
    {

        DB::beginTransaction();

        try{

            $listing = $this->webHookRepository->listing($request);

        }catch (Exception $e) {

            DB::rollBack();
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return (object)[
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ];
        }

        DB::commit();

        return (object)[
            'status'                => 200,
            'messages'              => config('status.status_code.200'),
            'data'                  => $listing
        ];
    }

    public function showItem($id)
    {

        DB::beginTransaction();

        try{

            $clientInfo = $this->webHookRepository->show($id);

        }catch (Exception $e) {

            DB::rollBack();
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return (object)[
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ];
        }

        DB::commit();

        return (object)[
            'status'                => 200,
            'messages'              => config('status.status_code.200'),
            'data'                  => $clientInfo,
        ];
    }


    public function createItem($request)
    {


        DB::beginTransaction();

        try {

            $data = $this->webHookRepository->create($request);

        } catch (Exception $e) {

            DB::rollBack();
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return (object)[
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ];
        }

        DB::commit();

        return (object)[
            'status'                => 201,
            'messages'              => config('status.status_code.201'),
            'data'        => $data
        ];
    }

    /* public function updateItem($request,$id)
    {

        $rules = [
            'business_name'     => 'required|string|max:50|min:2',
            'email'             => 'nullable|email|string|max:30',
            'contact_phone'     => 'nullable|numeric|digits_between:10,15',
            'expire_date'       => 'required|date',
            'seat'              => 'required|numeric'
        ];


        Validator::make($request->all(),$rules)->validate();


        $data = $request->all();

        if(!isset($request->active))
            $data['active'] = 0;
        else
            $data['active'] = 1;

        DB::beginTransaction();

        try{

            $this->webHookRepository->update($data, $id);

            $clientInfo = $this->webHookRepository->show($id);


        } catch (Exception $e) {

            DB::rollBack();
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return (object)[
                'status'            => 424,
                'messages'          =>config('status.status_code.424'),
                'errors'            => [$e->getMessage()]
            ];
        }

        DB::commit();

        return (object)[
            'status'                => 208,
            'messages'              => config('status.status_code.208'),
            'data'                  => $clientInfo,
        ];

    }

    public function deleteItem($id)
    {

        DB::beginTransaction();

        try{

            $delete = $this->webHookRepository->deleteItem($id);

            if( !$delete ){
                return (object)[
                    'status'    => 404,
                    'messages'   => config('status.status_code.404')
                ];
            }

        } catch (Exception $e) {

            DB::rollBack();
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return (object)[
                'status'    => 424,
                'messages'   => config('status.status_code.424'),
                'error'     => $e->getMessage()
            ];
        }

        DB::commit();

        return (object)[
            'status'    => 209,
            'messages'   => config('status.status_code.209'),
            'data'      => $delete
        ];

    } */


}
