<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use App\Services\AgentService;
use Auth;

class AgentController extends Controller
{
    protected $agentService;

    public function __construct()
    {
        $this->agentService = new AgentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::check()) {

            $data = new \stdClass;
            if(Auth::user()->can('agent-list')) {

                if(isset($request->perPage) && $request->perPage <= 150){
                    session(['perPage' => $request->perPage]);
                }
                $request->perPage = session()->has('perPage') ? session('perPage') : config('others.ROW_PER_PAGE');
                $result = $this->agentService->listItems($request);
                if( $result->status == 200 ){
                    $data->data     = $result->data;
                    $data->perPage  = $request->perPage;
                    $data->headerLink       = 'agent.index';
                    $data->routeLink        = 'agent.create';
                    $data->updateRouteLink  = 'agent.edit';
                }
                // dd($data);
                return view('agent.list')->with(['dataPack'=>$data])->withTitle('Agent');
            }

            return $this->noPermissionResponse();
        }

        return redirect("login")->withSuccess('Opps! You need to log in first!!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check()) {

            $data = new \stdClass;

            if(Auth::user()->can('agent-create')) {

                $data->routeLink    = 'agent.create';
                $data->headerLink   = 'agent.index';

                return view('agent.create')->with(['dataPack' => $data])->withTitle('Agent');

            }

            return $this->noPermissionResponse();

        }

        return redirect("login")->withSuccess('Opps! You need to log in first!!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check()) {

            if(Auth::user()->can('agent-store')) {

                $result = $this->agentService->createItem($request);

                if($result->status == 201){
                    session()->flash('success', 'Record '. $result->messages. ' successfully!');
                }else{
                    session()->flash('error', 'Can not Create !');
                }

                return redirect()->route('agent.index');
            }

            return $this->noPermissionResponse();

        }

        return redirect("login")->withSuccess('Opps! You need to log in first!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::check()) {

            $data = new \stdClass;

            if(Auth::user()->can('agent-edit')) {

                $result                     = $this->agentService->showItem($id);
                $data->agentInfo            = $result->data ? $result->data : "";
                $data->routeLink            = 'agent.create';
                $data->headerLink           = 'agent.index';

                return view('agent.edit')->with(['dataPack' => $data])->withTitle('Agent');

            }

            return $this->noPermissionResponse();

        }

        return redirect("login")->withSuccess('Opps! You need to log in first!!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::check()) {

            $data = new \stdClass;

            if(Auth::user()->can('agent-update')) {

                $result = $this->agentService->updateItem($request, $id);

                if($result->status == 208){
                    session()->flash('success', 'Record '. $result->messages. ' successfully!');
                }else{
                    session()->flash('error', 'Can not Update!');
                }

                return redirect()->route('agent.index');
            }

            return $this->noPermissionResponse();
        }


        return redirect("login")->withSuccess('Opps! You need to log in first!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::check()) {

            if(Auth::user()->can('agent-delete') && Agent::where('id', $id)->first()) {

                $result = $this->agentService->deleteItem($id);

                if($result->status == 209){

                    session()->flash('success', 'Record '. $result->messages. ' successfully!');

                }else{

                    session()->flash('error', 'Can not Delete !');
                }

                return redirect()->route('agent.index');

            }

            return $this->noPermissionResponse();

        }

        return redirect("login")->withSuccess('Opps! You need to log in first!!');

    }
}
