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
                                                <form action=" {{ route('social-media.store') }}" method="POST">
                                                    @csrf

                                                    <div class="row">

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="client_id">Client <sup class="text-danger"><i
                                                                        class="bi bi-asterisk"></i></sup>
                                                                {!!getTooltip('client_id.id')!!}</label>
                                                            <select class="form-select form-select-sm" aria-label="Media Type"
                                                                id="client_id" name="client_id" required>
                                                                <option selected disabled>Select Client</option>
                                                                @if (isset($dataPack->clientList))
                                                                    @foreach ($dataPack->clientList->data as $value)
                                                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="domain">Domain Name
                                                                {!!getTooltip('social_media.domain')!!}</label>
                                                            <input type="text" name="domain" id="domain"
                                                                class="form-control form-control-sm" value="{{ old('domain') }}">
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="ip">IP</label>
                                                            <input type="ip" class="form-control form-control-sm"
                                                                id="ip" name="ip" value="{{ old('ip') }}">
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="page_id">Page ID</label>
                                                            <input type="text" name="page_id" id="page_id"
                                                                class="form-control form-control-sm" value="{{ old('page_id') }}">
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="page_name">Page Name</label>
                                                            <input type="text" name="page_name" id="page_name"
                                                                class="form-control form-control-sm" value="{{ old('page_name') }}">
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="site_key"> Site Key
                                                                {!!getTooltip('social_media.site_key')!!}</label>
                                                            <input type="text" name="site_key" id="site_key"
                                                                class="form-control form-control-sm" value="{{ old('site_key') }}">
                                                        </div>

                                                       <div class="form-group col-md-4 mb-3">
                                                            <label for="page_access_token">Platform Access Token</label>
                                                            <input type="text" name="page_access_token" id="page_access_token"
                                                                class="form-control form-control-sm" value="{{ old('page_access_token') }}">
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="msg_server_ip">Message Server IP</label>
                                                            <input type="text" name="msg_server_ip" id="msg_server_ip"
                                                                class="form-control form-control-sm" value="{{ old('msg_server_ip') }}">
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="msg_server_port">Message Server Port</label>
                                                            <input type="text" name="msg_server_port" id="msg_server_port"
                                                                class="form-control form-control-sm" value="{{ old('msg_server_port') }}">
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="socket_ip">Socket IP</label>
                                                            <input type="text" name="socket_ip" id="socket_ip"
                                                                class="form-control form-control-sm" value="{{ old('socket_ip') }}">
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="socket_port">Socket Port</label>
                                                            <input type="text" name="socket_port" id="socket_port"
                                                                class="form-control form-control-sm" value="{{ old('socket_port') }}">
                                                        </div>

                                                       <div class="form-group col-md-4 mb-3">
                                                            <label for="api_url">API URL</label>
                                                            <input type="text" name="api_url" id="api_url"
                                                                class="form-control form-control-sm" value="{{ old('api_url') }}">
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="api_token">API Access Token<sup class="text-danger"><i
                                                                class="bi bi-asterisk"></i></sup></label>
                                                            <input type="text" name="api_token" id="api_token"
                                                                class="form-control form-control-sm" value="{{ $dataPack->apiToken }}" readonly>
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="media_type">Social Platform <sup class="text-danger"><i
                                                                        class="bi bi-asterisk"></i></sup>
                                                                {!!getTooltip('media_type.id')!!}</label>
                                                            <select class="form-select form-select-sm" aria-label="Media Type" value="{{ old('media_type') }}"
                                                                id="media_type" name="media_type" >
                                                                <option selected disabled>Select Social Platform</option>
                                                                @if (isset($dataPack->mediaType))
                                                                    @foreach ($dataPack->mediaType as $key => $value)
                                                                        <option value="{{ $value }}">{{ $value }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="active">Active <sup class="text-danger"><i
                                                                        class="bi bi-asterisk"></i></sup>{!!getTooltip('social_media.active')!!}</label>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox"
                                                                    role="switch" id="active"
                                                                    name="active">
                                                                <label class="form-check-label" for="active">Select
                                                                    Status</label>
                                                            </div>
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
