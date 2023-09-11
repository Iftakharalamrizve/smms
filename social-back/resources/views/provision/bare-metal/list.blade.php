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
                            {{-- @dd($dataPack->data) --}}
                            <div class="card-body p-0">
                                @include('common.success_error')
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle table-striped align-middle table-sm">
                                        <thead class="g-thead">
                                            <tr>
                                                <th scope="col">Node Key</th>
                                                <th>Node</th>
                                                <th>Client</th>
                                                <th>IP</th>
                                                <th>Used From</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($dataPack))
                                                @foreach ($dataPack->data as $item)
                                                    <tr>
                                                        <td>{{$item->node_key}}</td>
                                                        <td>{{$item->bareMetal ? $item->bareMetal->label:''}}</td>
                                                        <td>{{$item->brick ? $item->brick->label:''}}</td>
                                                        <td>{{$item->ip}}</td>
                                                        <td>@if(isset($item->register_ts)){{$item->register_ts}}@endif</td>
                                                        <td>
                                                            @if($item->register_ts == 0 || !isset($item->register_ts))
                                                                <form action="{{ route('bare-metal.destroy', $item->node_key) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="text-danger border-0 bg-transparent p-0" title="Delete" onclick="return confirm('Action will delete the Bare Metal Permanently.')"><i class="bi bi-trash3"></i></button>
                                                                </form>
                                                            @endif
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
