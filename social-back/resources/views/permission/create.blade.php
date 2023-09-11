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
                                                <form action=" {{ route('permissions.store') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="group">Group <sup class="text-danger"><i class="bi bi-asterisk"></i></sup></label>
                                                            <select class="form-select form-select-sm" aria-label="Client ID"
                                                                id="group" name="group">
                                                                <option selected disabled>--Select--</option>
                                                                @foreach ($dataPack->groups as $group)
                                                                    <option value="{{ $group->id }}" {{old('group') == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('group'))
                                                                <small class="text-danger">{{ $errors->first('group') }}</small>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="name">Permission Name <sup class="text-danger"><i class="bi bi-asterisk"></i></sup></label>
                                                            <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{old('name') ?? ''}}">
                                                            @if ($errors->has('name'))
                                                                <small class="text-danger">{{ $errors->first('name') }}</small>
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
