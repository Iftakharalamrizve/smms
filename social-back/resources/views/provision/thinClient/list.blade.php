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
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle table-striped align-middle table-sm">
                                        <thead class="g-thead">
                                            <tr>
                                                <th scope="col">PS Key</th>
                                                <th>Account</th>
                                                <th>Expiry Date</th>
                                                <th>Max Device</th>
                                                <th>Key Userd Count</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($dataPack))
                                                @foreach ($dataPack->data as $item)
                                                    <tr>
                                                        <td>{{$item->ps_key}}</td>
                                                        <td>{{$item->account->business_name}}</td>
                                                        <td>{{$item->expire_date}}</td>
                                                        <td>{{$item->max_device}}</td>
                                                        <td>{{$item->key_used_count}}</td>
                                                        <td>
                                                            <div class="d-flex gap-3">
                                                                {{-- <a class="text-primary" href="{{route('provision-thin-client.edit', $item->ps_key)}}"><i class="bi bi-pencil-square"></i></a> --}}

                                                                <form action="{{ route('provision-thin-client.destroy', $item->ps_key) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="text-danger border-0 bg-transparent p-0" title="Delete" onclick="return confirm('Action will delete this permanently.')"><i class="bi bi-trash"></i></button>
                                                                </form>
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
