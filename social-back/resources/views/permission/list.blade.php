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
                                        <table
                                            class="table table-bordered align-middle table-striped align-middle table-sm">
                                            <thead class="g-thead">
                                                <tr>
                                                    <th scope="col">Sl.</th>
                                                    <th>Name</th>
                                                    <th>Slug</th>
                                                    {{-- <th>Action</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dataPack->data as $group)
                                                    @php
                                                        $i = 0;   
                                                    @endphp
                                                    <tr>
                                                        <td colspan="4"><h5>{{$group->name}}</h5></td>
                                                    </tr>
                                                    @foreach ($group->permissions as $permission)
                                                        <tr>
                                                            <td>{{++$i}}</td>
                                                            <td>{{$permission->name}}</td>
                                                            <td>{{$permission->slug}}</td>
                                                            {{-- <td>
                                                                <div class="d-flex gap-2">
                                                                    <a class="text-primary" href="{{route('permissions.edit', $permission->id)}}"><i class="bi bi-pencil-square"></i></a>
                                                                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="text-danger border-0 bg-transparent p-0" title="Delete" onclick="return confirm('Action will delete the role.')"><i class="bi bi-trash"></i></button>
                                                                    </form>
                                                                </div>
                                                            </td> --}} 
                                                        </tr>
                                                    @endforeach
                                                @endforeach
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
