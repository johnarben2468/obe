
@extends('layouts/index')


@section('header')
Settings
@stop
@section('content')
 <div class="row">
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Edit Settings
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
    
    @if(Session::get('msgsuccess'))
      <div class="alert alert-success fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <center>{{ Session::get('msgsuccess') }}</center>
      </div>
      {{ Session::forget('msgsuccess') }}
    @endif
    @if(Session::get('msgfail'))
      <div class="alert alert-danger fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <center>{{ Session::get('msgfail') }}</center>
      </div>
      {{ Session::forget('msgfail') }}
    @endif

                                    {{ Form::open(['role'=>'form','type' => 'POST', 'url' => '/admin/settings', 'files' => true]) }}
                                        
                                        <?php
                                        $institute = Institute::find(Auth::user()->institute_id);
                                        ?>
                                        <div class="form-group @if($errors->has('institute_name')) has-error @endif">
                                            <label>Institute Name:</label>
                                            @if($errors->has('institute_name'))
                                            <label class="control-label" for="inputError">{{ $errors->first('institute_name') }}</label>
                                            @endif
                                            {{ Form::text('institute_name', $institute->name, array('class' => 'form-control','maxlength'=>'255')) }}          
                                        </div>
                                        <div class="form-group @if($errors->has('mission')) has-error @endif">
                                            <label>Institute Mission:</label>
                                            @if($errors->has('mission'))
                                            <label class="control-label" for="inputError">{{ $errors->first('mission') }}</label>
                                            @endif
                                            {{ Form::textarea('mission', $institute->mission, array('class' => 'form-control', )) }}        
                                        </div>
                                        <div class="form-group @if($errors->has('vision')) has-error @endif">
                                            <label>Institute Vision:</label>
                                            @if($errors->has('vision'))
                                            <label class="control-label" for="inputError">{{ $errors->first('vision') }}</label>
                                            @endif
                                            {{ Form::textarea('vision', $institute->vision, array('class' => 'form-control',)) }}   
                                        </div>
                                        <div class="form-group @if($errors->has('header_file')) has-error @endif">
                                            <label>Institute Header:</label>
                                            @if($errors->has('header_file'))
                                            <label class="control-label" for="inputError">{{ $errors->first('header_file') }}</label>
                                            @endif
                                            {{ Form::file('header_file', ['class' => 'form-control', 'accept' => 'image/*']) }}         
                                        </div>

                                        
                                        <center>
                                        <button type="submit" class="btn btn-default">Save</button>
                                        </center>
                                    {{ Form::close() }}
                                </div>
                                <div class="col-lg-6">
                                    
                                </div>
                               
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
@stop
