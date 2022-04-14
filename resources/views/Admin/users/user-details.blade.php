@extends('Admin.index')
@section('content')

<div class="row gutters-sm">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="{{Storage::url($user->getAttribute('avatar'))}}" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                        <h4>{{$user->getAttribute('personal-details')['first-name'].' '.$user->getAttribute('personal-details')['last-name']}}</h4>
                        <p class="text-secondary mb-1">{{$user->getAttribute('personal-details')['headline']}}</p>
                        <p class="text-muted font-size-sm">{{$user->getAttribute('personal-details')['biography']}}</p>
                        <!-- <button class="btn btn-primary">Follow</button> -->
                        @can('send-support-message-to-user')
                        <button class="btn btn-outline-primary">{{trans('app.users.send-message')}}</button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="" style="margin: 6px;">
                        <i class="fab fa-internet-explorer"></i>&emsp13;
                        {{trans('app.users.Website')}}
                    </h6>
                    <a href="{{$user->getAttribute('personal-details')['social']['website']}}">
                        <span class="text-secondary">{{$user->getAttribute('personal-details')['social']['website']}}</span>
                    </a>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="" style="margin: 6px;">
                        <i class="fab fa-linkedin-in"></i>&emsp13;
                        {{trans('app.users.Linked-In')}}
                    </h6>
                    <span class="text-secondary">{{$user->getAttribute('personal-details')['social']['linkedIn']}}</span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="" style="margin: 6px;">
                        <i class="fab fa-twitter"></i>&emsp13;
                        {{trans('app.users.Twitter')}}
                    </h6>
                    <span class="text-secondary">{{$user->getAttribute('personal-details')['social']['twitter']}}</span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="" style="margin: 6px;">
                        <i class="fab fa-youtube"></i>&emsp13;
                        {{trans('app.users.Youtube')}}
                    </h6>
                    <span class="text-secondary">{{$user->getAttribute('personal-details')['social']['youtube']}}</span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="" style="margin: 6px;">
                        <i class="fab fa-facebook"></i>&emsp13;
                        {{trans('app.users.Facebook')}}
                    </h6>
                    <span class="text-secondary">{{$user->getAttribute('personal-details')['social']['facebook']}}</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">{{trans('app.users.full-name')}}</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{$user->getAttribute('personal-details')['first-name'].' '.$user->getAttribute('personal-details')['last-name']}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">{{trans('app.users.email')}}</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{$user->email}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">{{trans('app.users.user-name')}}</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{$user->user_name}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">{{trans('app.users.role')}}</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{$user->getRoleName()}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">{{trans('app.users.phone')}}</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{$user->getAttribute('personal-details')['phone']}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">{{trans('app.address.address')}}</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{$user->getAttribute('personal-details')['address']['city'] .', '.
                        $user->getAttribute('personal-details')['address']['state'].', '.
                        $user->getAttribute('personal-details')['address']['country']}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">{{trans('app.created-at')}}</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{(new Carbon\Carbon($user->getAttribute('created_at')))->format('Y-m-d H:i') }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">{{trans('app.updated-at')}}</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{(new Carbon\Carbon($user->getAttribute('updated_at')))->format('Y-m-d H:i') }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">{{trans('app.users.account-status')}}</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{$user->getAttribute('settings.status')}}
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h6 class="mb-0">{{trans('app.users.permissions')}}</h6>
                    </div>
                </div>
                <hr>
                <div class=" text-secondary">
                    @foreach($user->getPermissions() as $val)
                    <label class="mr-4 mb-3"><i class="nav-icon far fa-circle text-info"></i>
                        {{$val}}
                    </label>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')


@endpush
@push('style')


@endpush
@endsection
