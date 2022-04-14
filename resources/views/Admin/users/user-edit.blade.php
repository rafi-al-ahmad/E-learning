@extends('Admin.index')
@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8 mx-auto">
        <h2 class="h3 mb-4 page-title">{{trans('app.users.editing-account')}}</h2>
        <div class="my-4">
            <hr>
            <div class="row mt-5 align-items-center">
                <div class="col-md-3 text-center mb-5">
                    <form role="form" action="{{ route('admin.updateAccountAvatar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$user->getAttribute('_id')}}">
                        <div>
                            <div class="avatar avatar-xl">
                                <img src="{{Storage::url($user->getAttribute('avatar'))}}" id="avatar" alt="..." class="avatar-img rounded-circle" />
                            </div>
                            <input id="img-file-data" type="hidden" name="avatar">
                        </div>
                        <div>
                            <a class="btn mt-3 btn-block btn-primary" data-toggle="modal" data-target="#exampleModalCenter">{{trans('app.users.change-avatar')}}</a>
                            <button type="submit" id="img-file-submit" class="btn btn-block btn-outline-success">{{trans('app.save')}}</button>
                            </div>
                    </form>
                </div>
                <div class="col">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h4 class="mb-1">{{$user->getAttribute('personal-details')['last-name']}}, {{$user->getAttribute('personal-details')['first-name']}}</h4>
                            <p class="small mb-3"><span class="badge badge-dark">{{$user->getAttribute('personal-details')['address']['city']}}, {{ $user->getAttribute('personal-details')['address']['country']}}</span></p>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-7">
                            <p class="text-muted">
                                {{$user->getAttribute('personal-details')['biography']}}
                            </p>
                        </div>
                        <div class="col">
                            <p class="small mb-0 text-muted">{{$user->getAttribute('personal-details')['address']['street-one']}}, {{$user->getAttribute('personal-details')['address']['street-two']}}</p>
                            <p class="small mb-0 text-muted">{{$user->getAttribute('personal-details')['phone']}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-4" />
            <form role="form" action="{{ route('admin.updateAccountDetails') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{$user->getAttribute('_id')}}">
                <!-- <hr class="my-4" /> -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="firstname">{{trans('app.users.firstname')}}</label>
                        <input  type="text" value="{{$user->getAttribute('personal-details')['first-name']}}" name="first-name" id="firstname" class="form-control" placeholder="Brown" />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lastname">{{trans('app.users.lastname')}}</label>
                        <input required type="text" value="{{$user->getAttribute('personal-details')['last-name']}}" name="last-name" id="lastname" class="form-control" placeholder="Asher" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">{{trans('app.users.email')}}</label>
                        <input required type="email" value="{{$user->getAttribute('email')}}" class="form-control" name="email" id="inputEmail4" placeholder="brown@asher.me" />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputuser_name4">{{trans('app.users.user-name')}}</label>
                        <input required type="text" value="{{$user->getAttribute('user_name')}}" class="form-control" name="user_name" id="inputuser_name4" placeholder="brown@asher.me" />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="role">{{trans('app.users.role')}}</label>
                        <select name="role" id="role" class="form-control">
                            @foreach(App\Models\Role::all() as $role)
                            <option value="{{$role->_id}}" {{ ($user->getAttribute('role.id') == $role->_id)? 'selected' :'' }}   >{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label for="inputAddress5">Address</label>
                    <input required type="text" value="" class="form-control" name ="" id="inputAddress5" placeholder="P.O. Box 464, 5975 Eget Avenue" />
                </div> -->

                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="inputCountry">{{trans('app.address.country')}}</label>
                        <input required type="text" value="{{ $user->getAttribute('personal-details')['address']['country']}}" class="form-control" name="country" id="inputCountry" placeholder="Nec Urna Suscipit Ltd" />
                    </div>
                    <div class="form-group col-md-5">
                        <label for="inputState5">{{trans('app.address.state')}}</label>
                        <input required type="text" value="{{ $user->getAttribute('personal-details')['address']['state']}}" class="form-control" name="state" id="inputCountry" placeholder="Nec Urna Suscipit Ltd" />
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputZip5">{{trans('app.address.zip')}}</label>
                        <input type="text" value="{{$user->getAttribute('personal-details')['address']['zip']}}" class="form-control" name="zip" id="inputZip5" placeholder="98232" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="city">{{trans('app.address.city')}}</label>
                        <input required type="text" value="{{$user->getAttribute('personal-details')['address']['city']}}" name="city" id="city" class="form-control" placeholder="Brown" />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="street-one">{{trans('app.address.street-one')}}</label>
                        <input required type="text" value="{{$user->getAttribute('personal-details')['address']['street-one']}}" name="street-one" id="street-one" class="form-control" placeholder="Brown" />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="street-two">{{trans('app.address.street-two')}}</label>
                        <input type="text" value="{{$user->getAttribute('personal-details')['address']['street-two']}}" name="street-two" id="street-two" class="form-control" placeholder="Asher" />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="phone">{{trans('app.users.phone')}}</label>
                        <input type="text" value="{{$user->getAttribute('personal-details')['phone']}}" name="phone" id="phone" class="form-control" placeholder="Brown" />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="headline">{{trans('app.users.headline')}}</label>
                        <input type="text" value="{{$user->getAttribute('personal-details')['headline']}}" name="headline" id="headline" class="form-control" placeholder="Brown" />
                    </div>
                </div>
                <div class="form-group ">
                    <label for="biography">{{trans('app.users.biography')}}</label>
                    <textarea rows="4" name="biography" id="biography" class="form-control">{{$user->getAttribute('personal-details')['biography']}}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">{{trans('app.save')}}</button>
                <button type="reset" class="btn  btn-outline-secondary ">{{trans('app.reset')}}</button>
            </form>


            <form role="form" action="{{ route('admin.updateAccountPassword') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{$user->getAttribute('_id')}}">
                <hr class="my-4" />
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputPassword5">{{trans('app.users.new-password')}}</label>
                            <input required type="password" name="password" class="form-control" id="inputPassword5" />
                        </div>
                        <div class="form-group">
                            <label for="inputPassword6">{{trans('app.users.confirm-password')}}</label>
                            <input required type="password" name="password_confirmation" class="form-control" id="inputPassword6" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">{{trans('app.users.password-requirements')}}</p>
                        <p class="small text-muted mb-2">To create a new password, you have to meet all of the following requirements:</p>
                        <ul class="small text-muted pl-4 mb-0">
                            <li>Minimum 8 character</li>
                            <li>At least one special character</li>
                            <li>At least one number</li>
                            <li>Can’t be the same as a previous password</li>
                        </ul>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{trans('app.users.update-password')}}</button>
                <button type="reset" class="btn btn-outline-secondary">{{trans('app.reset')}}</button>
            </form>
            <hr>

            @if($user->getAttribute('settings')['status'] == 'activated')
            <form role="form" id="close-account-form" action="{{ route('admin.CloseUserAccount') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{$user->getAttribute('_id')}}">
            </form>
            <div class="form-group">
                <button type="" class="btn btn-block btn-outline-danger btn-lg" onclick="closeAccount()">{{trans('app.users.close-account')}}</button>
            </div>
            @else

            <form role="form" id="activate-account-form" action="{{ route('admin.ActivateUserAccount') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{$user->getAttribute('_id')}}">
            </form>
            <div class="form-group">
                <button type="" class="btn btn-block btn-outline-success btn-lg" onclick="activateAccount()">{{trans('app.users.activate-account')}}</button>
            </div>
            @endif
        </div>
    </div>
</div>






<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" id="close-cropper" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p>
                    <!-- Below are a series of inputs which allow file selection and interaction with the cropper api -->
                    <input class="btn btn-sm" type="file" id="fileInput" accept="image/*" />
                    <button class="btn float-right m-1 btn-outline-secondary btn-sm" id="btnRestore">Restore</button>
                    <button class="btn float-right m-1 btn-info btn-sm" id="btnCrop">Crop</button>
                </p>
                <div>
                    <canvas style="width: 100%; height: 100%;" id="canvas">
                        Your browser does not support the HTML5 canvas element.
                    </canvas>
                </div>

                <div id="result"></div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
                <div class="text-danger"> you sould save change after crooping!</div>
                <!-- <button type="button" class="btn float-left btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>




@push('scripts')
<script>
    function closeAccount() {
        if (confirm('Are you sure you want to close this account? \nif you press Ok user will not be able to access to the system!')) {
            event.preventDefault();
            document.getElementById('close-account-form').submit();
        }
    }

    function activateAccount() {
        if (confirm('Are you sure you want to activate this account?')) {
            event.preventDefault();
            document.getElementById('activate-account-form').submit();
        }
    }
</script>

<script src="{{url('')}}/cropper/cropper.js"></script>

<script>
    var canvas = $("#canvas"),
        context = canvas.get(0).getContext("2d"),
        $result = $('#avatar');

    $('#fileInput').on('change', function() {
        if (this.files && this.files[0]) {
            if (this.files[0].type.match(/^image\//)) {
                var reader = new FileReader();
                reader.onload = function(evt) {
                    var img = new Image();
                    img.onload = function() {
                        context.canvas.height = img.height;
                        context.canvas.width = img.width;
                        context.drawImage(img, 0, 0);
                        var cropper = canvas.cropper({
                            aspectRatio: 1 / 1
                        });
                        $('#btnCrop').click(function() {
                            // Get a string base 64 data url
                            var croppedImageDataURL = canvas.cropper('getCroppedCanvas').toDataURL("image/png");
                            $result.attr('src', croppedImageDataURL);
                            $('#img-file-data').attr('value', croppedImageDataURL)
                        });
                        $('#btnRestore').click(function() {
                            canvas.cropper('reset');
                            $result.empty();
                            canvas.cropper('destroy');
                        });
                        $('#close-cropper').click(function() {
                            canvas.cropper('reset');
                            $result.empty();
                            canvas.cropper('destroy');
                        });
                    };
                    img.src = evt.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            } else {
                alert("Invalid file type! Please select an image file.");
            }
        } else {
            alert('No file(s) selected.');
        }
    });
</script>

@endpush
@push('style')
<style>
    body {
        color: #8e9194;
        background-color: #f4f6f9;
    }

    .avatar-xl img {
        width: 110px;
    }

    .rounded-circle {
        border-radius: 50% !important;
    }

    img {
        vertical-align: middle;
        border-style: none;
    }

    .text-muted {
        color: #aeb0b4 !important;
    }

    .text-muted {
        font-weight: 300;
    }

    .form-control {
        display: block;
        width: 100%;
        /* height: calc(1.5em + 0.75rem + 2px); */
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 400;
        line-height: 1.5;
        color: #4d5154;
        background-color: #ffffff;
        background-clip: padding-box;
        border: 1px solid #eef0f3;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
</style>

<link rel="stylesheet" href="{{url('')}}/cropper/cropper.css">
<style>
    /* Limit image width to avoid overflow the container */
    img {
        max-width: 100%;
        /* This rule is very important, please do not ignore this! */
    }

    #canvas {
        height: 600px;
        width: 600px;
        background-color: #ffffff;
        cursor: default;
        border: 1px solid black;
    }
</style>

@endpush
@endsection
