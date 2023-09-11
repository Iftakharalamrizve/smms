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
                                                <h5 class="text-white mb-0">{{ $title ?? '' }} Form</h5>
                                            </div>
                                        </div>
                                        <div class="card-body">

                                            <div class="g-create-form">
                                                @if($errors->any())
                                                    {!! implode('', $errors->all('<div class="text-danger">-:message</div>')) !!}<br>
                                                @endif
                                                <form action="{{ route('roles.update', $dataPack->role->id) }}" method="POST">
                                                    @csrf
                                                    {{ method_field('put') }}
                                                    <label for="name">Role Name <sup class="text-danger"><i class="bi bi-asterisk"></i></sup></label>
                                                    <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{$dataPack->role->name}}"> 
                                            
                                                    <br><label for="">Permissions</label>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="vdi-permission-area">
                                                                @foreach ($dataPack->groups as $group)
                                            
                                                                    <section>
                                                                        <h6><strong>{{ $group->name }}</strong></h6>
                                                                        <ul>
                                                                            <li>
                                                                                <span><label><input type="checkbox" onchange="checkUncheckAll('{{$group->slug}}', this)" class="{{$group->slug}}"> Check/Uncheck All</label></span>
                                                                            </li>
                                                                            <li>
                                                                                @foreach ($group->permissions as $permission)
                                                                                    <span class="border-0">
                                                                                        <label>
                                                                                            <input class="{{$group->slug}}" name="permissions[{{$group->slug}}][]" type="checkbox" value="{{$permission->id}}" {{ in_array($permission->id, $dataPack->permissionIds) ? 'checked' : '' }}> {{$permission->name}}
                                                                                        </label>
                                                                                    </span>
                                                                                @endforeach
                                                                            </li>
                                                                        </ul>
                                                                    </section>
                                                                    
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <input type="submit" class="form-control form-control-sm" value="Update">
                                                </form>
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
@section('footerScript')
    @include('role.js')
@endsection