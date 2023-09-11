@extends('layout.app')

@section('content')
    <main class="g-page-wrap">
        <div>

        </div>
        <div class="g-page-content-area">

            <div class="g-page-content-main">

                <!--**********************************
                        Visualization & Graph
                 ***********************************-->

                <div class="container-fluid position-relative">

                    <div class="row">
                        <div class="col-md-12 p-3">
                            <form action="{{route('webhook-log.index')}}" method="get">
                                {{-- @dd($dataPack->socialMediaList) --}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="role">Select Page <sup class="text-danger"></sup>
                                        </label>

                                        <select class="form-select form-select-sm" aria-label="Client ID"
                                            id="page_id" name="page_id">
                                            <option value="">--Select--</option>
                                            @foreach ($dataPack->socialMediaList as $value)
                                                <option value="{{$value->page_id}}" {{old('page_id') == $value->page_id ? 'selected' : '' }}>{{$value->page_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="role">Start Date<sup class="text-danger"></sup>
                                        </label>
                                        <input type="date" name="start_date" id="start_date"  value="{{ old('start_date', date('Y-m-d')) }}" class="form-control form-control-sm"/>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="role">End Date<sup class="text-danger"></sup>
                                        </label>
                                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', date('Y-m-d')) }}" class="form-control form-control-sm"/>
                                    </div>

                                    <div class="col-md-3">
                                        <br/>
                                        <button type="submit" class="btn btn-success btn-sm">Search</button>
                                    </div>

                                </div>


                            </form>

                        </div>

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
                                                <th>Create Date</th>
                                                <th>Page ID</th>
                                                <th>Page Name</th>
                                                <th>Type</th>
                                                <th>Log</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 0;
                                                @endphp
                                                @foreach ($dataPack->data as $item)
                                                    <tr>
                                                        <td>{{++$i}}</td>
                                                        <td>{{$item->created_at}}</td>
                                                        <td>{{$item->page_id}}</td>
                                                        <td>{{$item->socialMedia?$item->socialMedia->page_name:''}}</td>
                                                        <td>{{$item->type}}</td>
                                                        <td class="text-left">

                                                            <div style="min-height: 50px;background-color:black; color:white;text-align:left">
                                                                {{base64_decode($item->content)}}
                                                            </div>


                                                        </td>
                                                    </tr>
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
