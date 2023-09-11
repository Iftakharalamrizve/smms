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
                                                <h5 class="text-white mb-0">{{ $title ?? '' }} Create Form</h5>
                                            </div>
                                        </div>
                                        <div class="card-body">

                                            <div class="g-create-form">
                                                <!--Start Form-->
                                                <form action=" {{ route('users.store') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="first_name">First Name <sup
                                                                    class="text-danger"><i class="bi bi-asterisk"></i></sup>
                                                                {!!getTooltip('user.account.first_name')!!}</label>
                                                            <input type="text" name="first_name" id="first_name"
                                                                class="form-control form-control-sm" value="{{old('first_name') ?? ''}}">
                                                            @if ($errors->has('first_name'))
                                                                <small class="text-danger">{{ $errors->first('first_name') }}</small>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="last_name">Last Name <sup
                                                                    class="text-danger"><i class="bi bi-asterisk"></i></sup>
                                                                {!!getTooltip('user.account.last_name')!!}</label>
                                                            <input type="text" name="last_name" id="last_name"
                                                                class="form-control form-control-sm" value="{{old('last_name') ?? ''}}">
                                                            @if ($errors->has('last_name'))
                                                                <small class="text-danger">{{ $errors->first('last_name') }}</small>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="email">Email</label>
                                                            <input type="email" class="form-control form-control-sm"
                                                                id="email" name="email" value="{{old('email') ?? ''}}">
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="mobile">Mobile</label>
                                                            <input type="text" name="mobile" id="mobile"
                                                                class="form-control form-control-sm" value="{{old('mobile') ?? ''}}">
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="address">Address</label>
                                                            <input type="text" name="address" id="address"
                                                                class="form-control form-control-sm" value="{{old('address') ?? ''}}">
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="role">Role <sup class="text-danger"><i
                                                                        class="bi bi-asterisk"></i></sup>
                                                                {!!getTooltip('user.account.role')!!}</label>
                                                            <select class="form-select form-select-sm" aria-label="Client ID"
                                                                id="role" name="role">
                                                                <option selected disabled>--Select--</option>
                                                                @foreach ($dataPack->roles as $item)
                                                                    <option value="{{ $item->id }}" {{old('role') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('role'))
                                                                <small class="text-danger">{{ $errors->first('role') }}</small>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="username">Username <sup
                                                                    class="text-danger"><i class="bi bi-asterisk"></i></sup>
                                                                {!!getTooltip('user.account.username')!!}</label>
                                                            <input type="text" name="username" id="username"
                                                                class="form-control form-control-sm" value="{{old('username') ?? ''}}">
                                                            @if ($errors->has('username'))
                                                                <small class="text-danger">{{ $errors->first('username') }}</small>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="password">Password <sup
                                                                    class="text-danger"><i class="bi bi-asterisk"></i></sup>
                                                                {!!getTooltip('user.account.password')!!}</label>
                                                            <input type="password" name="password" id="username"
                                                                class="form-control form-control-sm" value="{{old('password') ?? ''}}">
                                                            @if ($errors->has('password'))
                                                                <small class="text-danger">{{ $errors->first('password') }}</small>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="confirm_password">Confirm Password <sup
                                                                    class="text-danger"><i class="bi bi-asterisk"></i></sup>
                                                                {!!getTooltip('user.account.confirm_password')!!}</label>
                                                            <input type="password" name="confirm_password" id="confirm_password"
                                                                class="form-control form-control-sm" value="{{old('confirm_password') ?? ''}}">
                                                            @if ($errors->has('confirm_password'))
                                                                <small class="text-danger">{{ $errors->first('confirm_password') }}</small>
                                                            @endif
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
