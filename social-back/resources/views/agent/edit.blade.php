@extends('layout.app')


@section('content')
    <main class="g-page-wrap">

        <div class="g-page-content-area mt-2 mt-md-4">

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
                                                <h5 class="text-white mb-0">{{ $title ?? '' }} Edit Form</h5>

                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="g-create-form">
                                                <!--Start Form-->
                                                {{-- @dd($dataPack->clientInfo->client_id) --}}
                                                <form
                                                    action="{{ route('client.update', $dataPack->clientInfo->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="business_name">Business Name <sup
                                                                    class="text-danger"><i class="bi bi-asterisk"></i></sup>
                                                                {!!getTooltip('client.business_name')!!}</label>
                                                            <input type="text" name="business_name" id="business_name"
                                                                class="form-control form-control-sm" required
                                                                @if (isset($dataPack->clientInfo)) value="{{ $dataPack->clientInfo->name }}" @endif>
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="email">Email</label>
                                                            <input type="email" class="form-control form-control-sm"
                                                                id="email" name="email"
                                                                @if (isset($dataPack->clientInfo)) value="{{ $dataPack->clientInfo->email }}" @endif>
                                                        </div>



                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="contact_name">Contact Name</label>
                                                            <input type="text" name="contact_name" id="contact_name"
                                                                class="form-control form-control-sm"
                                                                @if (isset($dataPack->clientInfo)) value="{{ $dataPack->clientInfo->contact_name }}" @endif>
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="contact_phone">Contact Phone</label>
                                                            <input type="number" name="contact_phone" id="contact_phone"
                                                                class="form-control form-control-sm"
                                                                @if (isset($dataPack->clientInfo)) value="{{ $dataPack->clientInfo->mobile }}" @endif>
                                                        </div>


                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="seat"> No. Seat<sup class="text-danger"><i
                                                                class="bi bi-asterisk"></i></sup>{!!getTooltip('client.seat')!!}</label>
                                                            <input type="number" name="seat" id="seat"
                                                                class="form-control form-control-sm" @if (isset($dataPack->clientInfo)) value="{{ $dataPack->clientInfo->seat }}" @endif>
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="expire_date">Expire Date<sup class="text-danger"><i
                                                                class="bi bi-asterisk"></i></sup>{!!getTooltip('client.expire_date')!!}</label>
                                                            <input type="date" class="form-control form-control-sm"
                                                                id="expire_date" name="expire_date" @if (isset($dataPack->clientInfo)) value="{{ $dataPack->clientInfo->expire_date }}" @endif>
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="client_active">Active <sup class="text-danger"><i
                                                                        class="bi bi-asterisk"></i></sup>
                                                                {!!getTooltip('client.active')!!}</label>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox"
                                                                    role="switch" id="active" name="active"
                                                                    @if (isset($dataPack->clientInfo) && $dataPack->clientInfo->status == 1) {{ 'checked ' }} @endif>
                                                                <label class="form-check-label" for="client_active">Select
                                                                    Account Status</label>
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4 mx-auto mt-4">
                                                            <button class="btn btn-primary w-100" type="submit">UPDATE
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
