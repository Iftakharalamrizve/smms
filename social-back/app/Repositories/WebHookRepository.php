<?php

namespace App\Repositories;

use App\Traits\QueryTrait;
use Carbon\Carbon;
use Exception;
use DB;
use Illuminate\Contracts\Session\Session;
use App\Models\Content;

class webHookRepository
{
    use QueryTrait;

    public function listing($request)
    {

        $result = '';

        if($request != null) {
            $whereFilterList = ['page_id'];
            $likeFilterList  = [];
            $query = Content::select('*')->with(['socialMedia']);
            $query = self::filterLog($request, $query, $whereFilterList, $likeFilterList);
    
            if($request->start_date && $request->end_date) {
               
                $query =  $query->whereBetween('created_at',[$request->start_date.' 00:00:00', $request->end_date.' 23:59:59']);
            } else {
                $query =  $query->whereBetween('created_at',[date('Y-m-d').' 00:00:00', date('Y-m-d').' 23:59:59']);
            }
            
            $result = $query->orderBy('created_at','DESC')->paginate( $request->perPage );

        } else {

            $result = Content::select('*')->orderBy('created_at','DESC')->get();

        }

        return $result;

    }

    public function show($id)
    {
        if (!empty($id)){

            return Content::findorfail($id);

        } else {

            return Content::orderBy('created_at','DESC')->take(1)->get();

        }

    }


    public function create(array $data)
    {

        $content                    = new Content();
        $content->page_id           = $data['pageId'];
        $content->type              = $data['type'];
        $content->content           = $data['content'];
        $content->platform_time     = $data['platformTime'];
        $content->save();

        return $content;
    }


    /* public function update(array $data, $id)
    {

        // Update user detail
        $content                     = Content::findorfail($id);
        $content->name               = $data['business_name'];
        $content->contact_name       = $data['contact_name'] ?? " ";
        $content->mobile             = $data['contact_phone'] ?? " ";
        $content->email              = $data['email'] ?? " ";
        $content->status             = $data['active'];
        $content->seat               = $data['seat'];
        $content->expire_date        = $data['expire_date'] ?? date('Y-m-d');
        $content->save();

        return $content;

    }

    public function deleteItem($id){

        if( Content::where('id', $id)->first() ){

            return Content::where('id', $id)->delete();

        }

        return false;
    }
 */
public static function filterLog($request, $query, array $whereFilterList, array $likeFilterList)
{
    $query = self::likeQueryFilter($request, $query, $likeFilterList);
    $query = self::whereQueryFilter($request, $query, $whereFilterList);

    return $query;

}
}
