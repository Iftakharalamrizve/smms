@extends('layout.app')


@section('content')
    <main class="g-page-wrap">

        <div class="g-page-content-area">

            <div class="g-page-content-main">

                <!--**********************************
                               Account Create Form
                     ***********************************-->
                <div class="g-create-form-area">
                    <div class="container-fluid">
                        <div class="g-create-form-main">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-secondary">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="text-white mb-0">{{ $title ?? '' }} Create Form</h5>
                                                {{-- @if (isset($dataPack->accountInfo) && $dataPack->accountInfo->status == 208)
                                                    <span class="text-success">Information Updated Successfully!!</span>
                                                @else
                                                    <span class="text-danger">Error Occurd While Update Information!!</span>
                                                @endif --}}
                                            </div>
                                        </div>
                                        <div class="card-body">

                                            <div class="g-create-form">
                                                <!--Start Form-->
                                                {{-- @dd($dataPack->node_key); --}}
                                                <form action=" {{ route('bare-metal.store') }}" method="POST">
                                                    @csrf
                                                    <div class="row">

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="node_key">Node Key <sup class="text-danger"><i
                                                                        class="bi bi-asterisk"></i></sup>
                                                                    {!!getTooltip('provision.bare-metal.node_key')!!}
                                                            </label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="node_key" name="node_key" readonly value="{{$dataPack->node_key}}">

                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="brick_id">Client ID
                                                                    {!!getTooltip('provision.bare-metal.brick_id')!!}
                                                                </label>
                                                            <select class="form-select form-select-sm" aria-label="Client ID"
                                                                id="brick_id" name="brick_id">
                                                                <option selected disabled>--Select--</option>
                                                                @if (isset($dataPack->data))
                                                                    @foreach ($dataPack->data as $item)
                                                                        <option value="{{ $item->brick_id }}">
                                                                            {{ $item->label }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>

                                                        </div>
                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="ip">IP
                                                                    {!!getTooltip('cprovision.bare-metal.ip')!!}
                                                            </label>
                                                            <input type="text" name="ip" id="ip"
                                                                class="form-control form-control-sm">

                                                        </div>


                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4 mx-auto mt-4">
                                                            <button class="btn btn-primary w-100" type="submit">SAVE
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!--End Form-->
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--                End Create Form-->


            </div>
        </div>

    </main>
@endsection
