<?php
namespace App\Services;

use App\Repositories\SocialMediaRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SocialMediaService
{
    protected $socialMediaRepository;

    public function __construct()
    {

        $this->socialMediaRepository = new SocialMediaRepository;

    }


    public function listItems($request = NULL)
    {

        DB::beginTransaction();

        try{

            $listing = $this->socialMediaRepository->listing($request);

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

            $socialMediaInfo = $this->socialMediaRepository->show($id);

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
            'data'                  => $socialMediaInfo,
        ];
    }


    public function getPageItem($id)
    {

        $socialMediaInfo = $this->socialMediaRepository->getPageInfo($id);

        return (object)[
            'status'                => 200,
            'messages'              => config('status.status_code.200'),
            'data'                  => $socialMediaInfo,
        ];

    }

    public function createItem($request)
    {

        $rules = [
            'client_id'             => 'required',
            'domain'                => 'max:255',
            'ip'                    => 'max:50',
            'page_id'               => 'max:255',
            'page_name'             => 'max:255',
            'site_key'              => 'max:255',
            'page_access_token'     => 'max:255',
            'msg_server_ip'         => 'max:50',
            'msg_server_port'       => 'max:10',
            'socket_ip'             => 'max:50',
            'socket_port'           => 'max:10',
            'api_url'               => 'max:50',
            'api_token'             => 'max:255',
            'media_type'            => 'required|max:100'

        ];


        Validator::make($request->all(),$rules)->validate();

        $data   = $request->all();

        if(!isset($request->active))
            $data['status'] = 0;
        else
            $data['status'] = 1;

        // return $data;

        // dd($data);

        DB::beginTransaction();

        try {

            // dd($data);
            $id = $this->socialMediaRepository->create($data);

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
            'messages'               => config('status.status_code.201'),
            'user_created'          => $id
        ];
    }

    public function updateItem($request,$id)
    {

        $rules = [
            'client_id'             => 'required',
            'domain'                => 'max:255',
            'ip'                    => 'max:50',
            'page_id'               => 'max:255',
            'page_name'             => 'max:255',
            'site_key'              => 'max:255',
            'page_access_token'     => 'max:255',
            'msg_server_ip'         => 'max:50',
            'msg_server_port'       => 'max:10',
            'socket_ip'             => 'max:50',
            'socket_port'           => 'max:10',
            'api_url'               => 'max:50',
            'api_ip'                => 'max:255',
            'media_type'            => 'required|max:100'

        ];


        Validator::make($request->all(),$rules)->validate();


        $data = $request->all();

        if(!isset($request->active))
            $data['status'] = 0;
        else
            $data['status'] = 1;

        DB::beginTransaction();

        try {

            $socialMediaInfo = $this->socialMediaRepository->update($data, $id);

        } catch (Exception $e) {

            DB::rollBack();
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return (object)[
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'errors'            => [$e->getMessage()]
            ];
        }

        DB::commit();

        return (object)[
            'status'                => 208,
            'messages'              => config('status.status_code.208'),
            'data'                  => $socialMediaInfo,
        ];
    }

    public function deleteItem($id)
    {

        DB::beginTransaction();

        try{

            $delete = $this->socialMediaRepository->deleteItem($id);
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
    }

    public function getAgentMode()
    {
        // agent in agent main queue this mode is ready mode 
        // agent is not in main agent queue and agent exist in agent service queue this is called agent busy mode 
        // agent not exist in main agent queue and not exist in agent service queue this called agent break mode .
    }

    // public function deleteItem($id)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $delete = $this->socialMediaRepository->deleteItem($id);
    //         if (!$delete) {
    //             return (object)[
    //                 'status' => 404,
    //                 'messages' => config('status.status_code.404')
    //             ];
    //         }
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

    //         return (object)[
    //             'status' => 424,
    //             'messages' => config('status.status_code.424'),
    //             'error' => $e->getMessage()
    //         ];
    //     }

    //     DB::commit();

    //     return (object)[
    //         'status' => 209,
    //         'messages' => config('status.status_code.209'),
    //         'data' => $delete
    //     ];
    // }


}
