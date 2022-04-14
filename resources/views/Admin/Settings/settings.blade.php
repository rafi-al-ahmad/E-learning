@extends('Admin.index')
@section('content')
<div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->
    <form role="form" method="POST" action="{{ route('admin.settings.updateBasics') }}" enctype="multipart/form-data">
        @csrf
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">{{trans('app.settings.BasicInfo')}}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button> -->
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Appname">{{trans('app.settings.AppName')}}</label>
                            <input name="appName" value="{{ isset($settings->appName) ? $settings->appName :'' }}" type="text" class="form-control" id="Appname" placeholder="Enter Application name">
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{trans('app.settings.defaultLanguage')}}</label>
                            <select name="defaultLanguage" class="form-control">
                                @foreach($languages as $lang)
                                <option value="{{$lang->code}}" {{ isset($settings->defaultLanguage) ? ($settings->defaultLanguage == $lang->code ? 'selected' : '') :'' }}>{{ ucfirst($lang->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <h5></h5>

                <div class="row ">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="logo">{{trans('app.settings.logo')}}</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="logo" type="file" class="form-control" id="logo">
                                    <label class="custom-file-label" id="logo-file-label" for="logo">Choose file</label>
                                </div>
                            </div>
                            <p class="help-block">logo size must be less than 512 KB</p>
                        </div>
                        <div class="form-group d-flex justify-content-center ">
                            <img class="img img-responsive" id="img-logo" src="{{ isset($settings->logo) ? Storage::url($settings->logo) :'' }}" src="" alt="Photo">
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="icon">{{trans('app.settings.favicon')}}</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="icon" type="file" class="form-control" id="icon">
                                    <label class="custom-file-label" id="icon-file-label" for="icon">Choose file</label>
                                </div>
                            </div>
                            <p class="help-block">Favicon size must be less than 10 KB</p>
                        </div>
                        <div class="form-group d-flex justify-content-center ">
                            <img class="img img-responsive" id="img-icon" src="{{ isset($settings->favicon) ? Storage::url($settings->favicon) :'' }}" alt="Photo">
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">{{ trans('app.save')}}</button>
                <button class="btn" type="reset">{{ trans('app.reset')}}</button>
            </div>
        </div>
        <!-- /.card -->
    </form>
    <!-- /form -->

    <form role="form" action="{{ route('admin.settings.updateSEO') }}" method="post">
        @csrf
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">{{trans('app.settings.SEO')}}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>{{trans('app.settings.description')}}</label>
                            <textarea name="appDescription" class="form-control" rows="2" placeholder="Enter ...">{{ isset($settings->appDescription) ? $settings->appDescription :'' }}</textarea>
                        </div>
                        <?php
                        $keywords = '';
                        foreach ($settings->keyWords as $word) {
                            $keywords .= ',' . $word;
                        }
                        ?>
                        <div class="form-group">
                            <label>{{trans('app.settings.keyWords')}}</label>
                            <input name="tags" value="{{$keywords}}" class="custom-file-input" id="singleFieldTags2">
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">{{ trans('app.save')}}</button>
                <button class="btn" type="reset">{{ trans('app.reset')}}</button>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </form>
    <!-- /form -->


    <form role="form" action="{{ route('admin.settings.updateMaintenanceMode') }}" method="post">
        @csrf
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">{{trans('app.settings.maintenance')}}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button> -->
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>{{trans('app.settings.status')}}</label>
                            <select name="maintenanceMode" class="form-control">
                                <option value="false" {{ isset($settings->maintenanceMode) ? ($settings->maintenanceMode == 'false' ? 'selected' : '') :'' }}>{{trans('app.settings.opened')}}</option>
                                <option value="true" {{ isset($settings->maintenanceMode) ? ($settings->maintenanceMode == 'true' ? 'selected' : '') :'' }}>{{trans('app.settings.closed')}}</option>
                            </select>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>{{trans('app.settings.closedStatusMessage')}}</label>
                            <textarea name="maintenanceMessage" class="form-control" rows="1" placeholder="Enter ...">{{ isset($settings->maintenanceMessage) ? $settings->maintenanceMessage :'' }}</textarea>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">{{ trans('app.save')}}</button>
                <button class="btn" type="reset">{{ trans('app.reset')}}</button>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </form>
    <!-- /form -->

    <form role="form" action="{{ route('admin.settings.updateTimezone') }}" method="post">
        @csrf
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">{{trans('app.settings.timeZone')}}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button> -->
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>{{trans('app.settings.timeZoneCountry')}}</label> (current: {{ isset($settings->time) ? $settings->getAttribute('time.country') :'none' }})
                            <select name="country" id="countries_timezones1" class="form-control bfh-countries" data-country="{{ isset($settings->time) ? $settings->getAttribute('time.country') :'' }}"></select>

                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>{{trans('app.settings.timeZoneCity')}}</label> (current: {{ isset($settings->time) ? $settings->getAttribute('time.timezone') :'none' }})
                            <select name="city" class="form-control bfh-timezones" data-country="countries_timezones1"></select>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">{{ trans('app.save')}}</button>
                <button class="btn" type="reset">{{ trans('app.reset')}}</button>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </form>
    <!-- /form -->

</div>

<!-- /.row -->
</section>
<!-- /.content -->

@push('scripts')
<script src="{{url('')}}/design/AdminLTE/plugins/bootstrap-formhelpers/bootstrap-formhelpers.js"></script>
<script></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>

<script src="{{url('')}}/design/AdminLTE/plugins/tag-it/js/tag-it.js" type="text/javascript" charset="utf-8"></script>

<script>
    $(function() {
        $('#singleFieldTags2').tagit();
    });
</script>
<script>
    $('#icon').on('change', function() {
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('#icon-file-label').html(fileName);
        document.getElementById('img-icon').src = window.URL.createObjectURL(this.files[0]);
    })


    $('#logo').on('change', function() {
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('#logo-file-label').html(fileName);
        document.getElementById('img-logo').src = window.URL.createObjectURL(this.files[0]);
    })
</script>
@endpush
@push('style')

<link href="{{url('')}}/design/AdminLTE/plugins/tag-it/css/jquery.tagit.css" rel="stylesheet" type="text/css">
<link href="{{url('')}}/design/AdminLTE/plugins/tag-it/css/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{url('')}}/design/AdminLTE/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">

<style>
    .img {
        max-width: 100%;
        max-height: 300px;
        height: auto;
        object-fit: 'contain';
    }
</style>
@endpush
@endsection
