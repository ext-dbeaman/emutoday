@inject('yearList', 'Emutoday\Http\Utilities\YearList')
@inject('seasonList', 'Emutoday\Http\Utilities\SeasonList')
@extends('admin.layouts.adminlte')
@section('title', 'Edit Magazine')
    @section('style-vendor')
        @parent
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="/themes/admin-lte/plugins/iCheck/all.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="/themes/admin-lte/plugins/select2/select2.min.css">

    @endsection

    @section('style-plugin')
        @parent
        <link rel="stylesheet" href="/css/my-redips.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="/themes/plugins/flatpickr/flatpickr.min.css" type="text/css" media="screen" />

    @endsection

    @section('style-app')
        @parent

    @endsection

    @section('scripts-vendor')
        <!-- Vendor Scripts that need to be loaded in the header before other plugin or app scripts -->
        @parent
    @endsection
    @section('scripts-plugin')
        <!-- Scripts  for code libraries and plugins that need to be loaded in the header -->
            <script src="/themes/plugins/ckeditor/ckeditor.js"></script>
            <script src="/themes/plugins/flatpickr/flatpickr.js"></script>

        @parent
    @endsection
    @section('scripts-app')
        <!-- App related Scripts  that need to be loaded in the header -->
        <script src="/js/redips-drag-min.js"></script>

        @parent
    @endsection

    @section('content')

    <div class="row">
        {!! Form::model($magazine, [
            'method' =>  'put',
            'route' => ['admin.magazine.update', $magazine->id]
            ]) !!}
            <div class="col-sm-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Magazine Content</h3>
                        @include('admin.components.boxtools', ['rte' => 'magazine', 'path' => 'admin/magazine/', 'cuser'=>$currentUser, 'id'=>$magazine->id])
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('year') !!}
                                    {!! Form::select('year', $yearList::all(), null, ['class'=> 'form-control select2','id'=>'select-year']) !!}
                                </div>
                            </div><!-- /.col-md-4 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('season') !!}
                                    {!! Form::select('season', $seasonList::all(), null, ['class'=> 'form-control select2','id'=>'select-season']) !!}
                                </div>
                            </div><!-- /.col-md-4 -->
                        </div><!-- /.row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('start_date') !!}
                                    {!! Form::text('start_date', null, ['class' => 'form-control', 'id'=>'start-date']) !!}
                                </div>
                            </div><!-- /.col-md-6 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('end_date') !!}
                                    {!! Form::text('end_date', null, ['class' => 'form-control', 'id'=>'end-date']) !!}
                                </div>
                            </div><!-- /.col-md-6 -->
                        </div><!-- /.row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('title') !!}
                                    {!! Form::text('title', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('teaser') !!}
                                    {!! Form::text('teaser', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('ext_url', 'Digital Version URL:') !!}
                                    {!! Form::text('ext_url', null, ['class' => 'form-control']) !!}
                                </div>
                            </div><!-- /.col-md-12 -->
                        </div><!-- /.row -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                        {!! Form::label('is_published','Published?', ['class'=>'text-center']) !!}
                                        <div class="row">
                                    <div class="col-md-4">
                                        {!! Form::radio('is_published', 1, $magazine->is_published,['class' => 'form-control', 'id'=>'is-published-yes']) !!}  {!! Form::label('is_published', 'yes') !!}
                                            </div><!-- /.col-md-4 -->
                                            <div class="col-md-4">
                                                {{ Form::radio('is_published', 0, $magazine->is_published,['class' => 'form-control', 'id'=>'is-published-no']) }}  {!! Form::label('is_published', 'no') !!}
                                            </div><!-- /.col-md-4-->
                                    </div><!-- /.row -->
                                </div><!-- /.form-group-->
                            </div><!-- /.col-md-6 -->
                            <div class="col-md-4">
                                <div class="form-group">
                            {!! Form::label('is_archived') !!}
                            <div class="row">
                                <div class="col-md-4">
                                    {!! Form::radio('is_archived', 1, $magazine->is_archived,['class' => 'form-control', 'id'=>'is-archived-yes']) !!}  {!! Form::label('is_archived', 'yes') !!}
                                </div><!-- /.col-md-6 -->
                                <div class="col-md-4">
                                    {!! Form::radio('is_archived', 0, $magazine->is_archived,['class' => 'form-control', 'id'=>'is-archived-no'] ) !!}  {!! Form::label('is_archived', 'no') !!}
                                </div><!-- /.col-md-6 -->
                            </div><!-- /.row -->
                        </div><!-- /.form-group -->
                            </div><!-- /.col-md-6 -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::text('original_story_ids', $original_story_ids, ['id'=> 'original_story_ids',  'class' => 'form-control']) !!}
                                    {!! Form::label('story_ids') !!}
                                    {!! Form::text('story_ids', null, ['id'=> 'story_ids',  'class' => 'form-control', 'readonly' => 'readonly']) !!}
                                </div>
                            </div><!-- /.col-md-4 -->
                        </div><!-- /.row -->
                        </div> <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="form-group">
                                {!! Form::submit('Update Magazine', ['class' => 'btn btn-primary btn-block']) !!}
                                {!! Form::close() !!}

                            </div>
                        </div><!-- /.box-footer -->
                </div> <!-- /.box -->
            </div> <!-- /.col-sm-6 -->

            <div class="col-sm-6">
                @if(count($mediafiles) > 0 )
                    @foreach ($mediafiles as $mediafile)
                                @include('admin.magazine.subviews.coverimage')
                    @endforeach
                @else
                                {{-- <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Add Cover Image</h3>
                                    </div><!-- /.box-header -->
                <div class="box-body">
            {!! Form::open(array('method' => 'post',
                                                    'route' => ['store_magazine_cover', $magazine->id],
                                                    'files' => true)) !!}
                    <div class="form-group">
                        {!! Form::file('photo', null, array('required','id' => 'photo', 'class'=>'form-control input-sm')) !!}
                    </div>
                            <div class="form-group">
                            {!! Form::label('caption') !!}
                            {!! Form::text('caption', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('note') !!}
                            {!! Form::text('note', null, ['class' => 'form-control']) !!}
                        </div>
                            <div class="form-group">
                            {!! Form::submit('Add Cover Image', array('class'=>'btn btn-primary')) !!}
                        </div>
                    {{ csrf_field() }}
                {!! Form::close() !!}

                    </div> <!-- /.box-body -->

                </div> <!-- /.box --> --}}
            @endif

            {{-- @each('admin.magazine.subviews.coverimage',$mediafiles, 'mediafile', 'admin.magazine.subviews.addcoverimage') --}}
            </div> <!-- /.col-sm-6 -->
        </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Magazine Builder</h3>
                        <div class="box-tools">
                            <div class="btn-toolbar btn-group-sm">
                                <a href="/preview/magazine/{{$magazine->id}}" class="btn bg-orange btn-sm"><i class="fa fa-eye"></i></a>
                            </div><!-- /.btn-toolbar -->
                        </div><!-- /.box-tools -->
                    </div>
                    <div class="box-body">
                @include('admin.magazine.templates.layoutindex')
            </div><!-- /.box-body -->
            <div class="box-footer">

            </div><!-- /.box-footer -->
            </div><!-- /.box -->
            </div>
        </div>
        @endsection
        @section('footer-vendor')

            @parent
        @endsection

        @section('footer-plugin')
            @parent
            <script src="/themes/admin-lte/plugins/select2/select2.full.min.js"></script>
            <!-- InputMask -->
            <script src="/themes/admin-lte/plugins/input-mask/jquery.inputmask.js"></script>
            <script src="/themes/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
            <script src="/themes/admin-lte/plugins/input-mask/jquery.inputmask.extensions.js"></script>
            <!-- date-range-picker -->
            {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script> --}}
            <!-- iCheck 1.0.1 -->
            <script src="/themes/admin-lte/plugins/iCheck/icheck.min.js"></script>
            <script src="/themes/plugins/flatpickr/flatpickr.min.js"></script>

            {{-- <script src="/themes/plugins/eonasdan-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script> --}}

        @endsection

        @section('footer-app')
            @parent
            <script src="/js/magbuild-redips.js"></script>

        @endsection

        @section('footer-script')
            @parent
            <script>

            $(function () {

                //Initialize Select2 Elements
                $(".select2").select2();


                    $('input[type="radio"]').iCheck({
                        checkboxClass: 'icheckbox_flat-blue',
                        radioClass: 'iradio_flat-blue'
                    })
                    $('#is-featured-no').iCheck('check');
                    $('#is-featured-yes').iCheck('disable');

                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                  checkboxClass: 'icheckbox_minimal-blue',
                  radioClass: 'iradio_minimal-blue'
                });
                //Red color scheme for iCheck
                $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                  checkboxClass: 'icheckbox_minimal-red',
                  radioClass: 'iradio_minimal-red'
                });
                //Flat red color scheme for iCheck
                $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                  checkboxClass: 'icheckbox_flat-green',
                  radioClass: 'iradio_flat-green'
                });

                    //Start Date picker
                    // $('#start-date').datetimepicker({
                    //     format: 'YYYY-MM-DD HH:mm:ss'
                    // });
                    // CKEDITOR.replace(this.el.id, {
                    //      customConfig: editorConfig
                    //    //  customConfig: '/themes/ckeditor_config_admin.js'
                    // });


                    CKEDITOR.replaceAll('.ckeditor',{
                        customConfig: '/themes/ckeditor_config_simple.js',
                        removePlugins:'Image'
                    });
                    // CKEDITOR.config.removeButtons= 'Image,Cut,Copy,Paste,Undo,Redo,Anchor,Underline,Strike,Subscript,Superscript,Source';

                // 	CKEDITOR.replace( 'story-content', {
                // 		// Define changes to default configuration here. For example:
              // filebrowserBrowseUrl : '/themes/plugins/kcfinder/browse.php?opener=ckeditor&type=files',
              //   filebrowserImageBrowseUrl: '/themes/plugins/kcfinder/browse.php?opener=ckeditor&type=images',
              //   filebrowserUploadUrl : '/themes/plugins/kcfinder/upload.php?opener=ckeditor&type=files',
              //   filebrowserImageUploadUrl : '/themes/plugins/kcfinder/upload.php?opener=ckeditor&type=images'
                //
                // 				} );

                    //End Date picker
                    // $('#end-date').datetimepicker({
                    // 	format: 'YYYY-MM-DD HH:mm:ss',
                    // 	useCurrent: false //Important! See Issue #1075
                    // });
                    // $("#start-date").on("dp.change", function (e) {
                    // 			$('#end-date').data("DateTimePicker").minDate(e.date);
                    // 	});
                    // 	$("#end-date").on("dp.change", function (e) {
                    // 			$('#start-date').data("DateTimePicker").maxDate(e.date);
                    // 	});



              });
              var check_in = document.getElementById("start-date").flatpickr({
                                  altInput: true,
                                   altInputClass: "form-control",
                                  altFormat: "m-d-Y",
                                  minDate: new Date(),
                                  onChange: function(dateObj, dateStr, instance) {
                                      check_out.set("minDate", dateObj.fp_incr(1));
                                  }
                                  });
              var check_out =document.getElementById("end-date").flatpickr({
                                 altInput: true,
                                  altInputClass: "form-control",
                                    altFormat: "m-d-Y",
                                       minDate: new Date(),
                                       onChange: function(dateObj, dateStr, instance) {
                                           check_in.set("maxDate", dateObj.fp_incr(-1));
                                       }
                                   });

                </script>


        @endsection
