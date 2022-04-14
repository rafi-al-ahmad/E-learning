<div class="row justify-content-center">

    <!-- view user btn -->
    <div class="col-lg-4">
        <a type="button" class="btn btn-sm btn-warning "title="{{trans('app.view')}}"  style="margin: 0px;" id="view_{{ $_id }}" href="{{route('admin.UserAccountDetails',$_id) }}">
            <i class="far fa-eye"></i>
        </a>
    </div>

    <!-- Edit user btn -->
    <div class="col-lg-4">
        <a type="button" class="btn btn-sm btn-info " title="{{trans('app.edit')}}" style="margin: 0px;" id="edit_{{ $_id }}" href="{{route('admin.UsersAccountEdit',$_id) }}">
            <i class="far fa-edit"></i>
        </a>
    </div>

    <!-- close account btn -->
    <div class="col-lg-4">
        <a type="button" class="btn btn-sm btn-danger "title="{{trans('app.users.close-account')}}"  style="margin: 0px;" id="close_{{ $_id }}" data-toggle="modal" href="closeUserAccount()" data-target="#myModal">
            <i class="fas fa-user-times"></i>
        </a>
    </div>

</div>


