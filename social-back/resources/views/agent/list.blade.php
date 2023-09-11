@extends('layout.app')

@section('content')
<main class="g-page-wrap">

    <div class="g-page-content-area">

        <div class="g-page-content-main">

            <!--**********************************
                    Visualization & Graph
             ***********************************-->

            <div class="container-fluid position-relative">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-body p-0">
                                @include('common.success_error')
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle table-striped align-middle table-sm">
                                        <thead class="g-thead">
                                            <tr>
                                                <th scope="col">SL</th>
                                                <th scope="col">ID</th>
                                                <th scope="col">Nick Name</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($dataPack))
                                                @foreach ($dataPack->data as $item)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$item->agent_id}}</td>
                                                        <td>{{$item->nick}}</td>
                                                        <td>{{$item->name}}</td>
                                                        <td>
                                                            @switch($item->active)
                                                                @case('Y')
                                                                    <span class="text-success fw-bold">Yes</span>
                                                                    @break

                                                                @case('N')
                                                                    <span class="text-danger fw-bold">No</span>
                                                                    @break
                                                            @endswitch
                                                        </td>
                                                        <td>
                                                            @switch($item->usertype)
                                                                @case('S')
                                                                    <span class="fw-bold">Supervisor</span>
                                                                    @break

                                                                @case('A')
                                                                    <span class="fw-bold">Agent</span>
                                                                    @break
                                                            @endswitch
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <a class="text-primary me-2" href="{{ route('agent.edit',$item->agent_id) }}" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                                                <a class="text-primary me-2" href="#" title="Reset Password" data-bs-toggle="modal" data-bs-target="#main_modal" onclick="changePassword('{{route('agent.update',[$item->agent_id])}}', '{{$item->agent_id}}')"><i class="bi bi-key"></i></a>
                                                                <a class="text-primary me-2" href="#" title="Archive" data-bs-toggle="modal" data-bs-target="#main_modal" onclick="archive('{{route('agent.update',[$item->agent_id])}}', '{{$item->agent_id}}')"><i class="bi bi-archive"></i></a>
                                                                {{-- <form action="{{ route('agent.destroy', $item->agent_id) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="text-danger border-0 bg-transparent" title="Delete" onclick="return confirm('Action will delete the Client permanently.')"><i class="bi bi-trash3"></i></button>
                                                                </form> --}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @include('layout.pagination')

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection

