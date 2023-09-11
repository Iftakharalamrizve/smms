@extends('layout.app')


@section('content')
    <main class="g-page-wrap">

        <div class="g-page-content-area">

            <div class="g-page-content-main">
                <div class="g-create-form-area">
                    <div class="container-fluid">
                        <div class="g-create-form-main">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-secondary">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="text-white mb-0">{{ $title ?? '' }} Create Form</h5>
                                            </div>
                                        </div>
                                        <div class="card-body">

                                            <div class="g-create-form">
                                                <!--Start Form-->
                                                <form action=" {{ route('provision-thin-client.store') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="account_id">Account <sup class="text-danger"><i
                                                                        class="bi bi-asterisk"></i></sup>
                                                                {!!getTooltip('provision.thinClient.account_id')!!}</label>
                                                            <select class="form-select form-select-sm" id="account_id"
                                                                name="account_id" required>
                                                                <option selected disabled>Select Account</option>
                                                                @if (isset($dataPack->accountList))
                                                                    @foreach ($dataPack->accountList->data as $value)
                                                                        <option value="{{ $value->account_id }}">
                                                                            {{ $value->business_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @if ($errors->has('account_id'))
                                                                <small
                                                                    class="text-danger">{{ $errors->first('account_id') }}</small>
                                                            @endif
                                                        </div>

                                                        {{-- <div class="form-group col-md-4 mb-3">
                                                            <label for="osimage">OS Image <sup class="text-danger"><i
                                                                        class="bi bi-asterisk"></i></sup></label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                   id="osimage" name="osimage">
                                                            @if ($errors->has('osimage'))
                                                                <small
                                                                    class="text-danger">{{ $errors->first('osimage') }}</small>
                                                            @endif
                                                        </div> --}}

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="expire_date">Expiry Date <sup class="text-danger"><i
                                                                        class="bi bi-asterisk"></i></sup>
                                                                {!!getTooltip('provision.thinClient.expire_date')!!}</label>
                                                            <input type="date" name="expire_date" id="expire_date"
                                                                class="form-control form-control-sm">
                                                            @if ($errors->has('expire_date'))
                                                                <small
                                                                    class="text-danger">{{ $errors->first('expire_date') }}</small>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="max_device">Max Device <sup class="text-danger"><i
                                                                        class="bi bi-asterisk"></i></sup>
                                                                {!!getTooltip('provision.thinClient.max_device')!!}</label>
                                                            <input type="number" name="max_device" id="max_device"
                                                                class="form-control form-control-sm">
                                                            @if ($errors->has('max_device'))
                                                                <small
                                                                    class="text-danger">{{ $errors->first('max_device') }}</small>
                                                            @endif
                                                        </div>

                                                        {{-- <div class="form-group col-md-4 mb-3">
                                                            <label for="key_used_count">Key Used Count <sup
                                                                    class="text-danger"><i class="bi bi-asterisk"></i></sup>
                                                                {!!getTooltip('provision.thinClient.key_used_count')!!}</label>
                                                            <input type="number" name="key_used_count" id="key_used_count"
                                                                class="form-control form-control-sm">
                                                            @if ($errors->has('key_used_count'))
                                                                <small
                                                                    class="text-danger">{{ $errors->first('key_used_count') }}</small>
                                                            @endif
                                                        </div> --}}

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

            </div>
        </div>

    </main>
@endsection
