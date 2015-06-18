
@extends('layouts/index')


@section('header')
    <?php
    $institute = Institute::find(Auth::user()->institute_id);
    echo $institute->name;
    ?>
@stop
@section('content')
 <div class="row">
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{$program->title}} Program
                        </div>
                        <div class="panel-body">
                            <div class="row">
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
                <div class="col-lg-6">
                 
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Course</th>
                                            <th>Units</th>
                                            <th>Department</th>
                                            <th>Controls</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($progcours as $progcour)
                                        <?php
                                        $course = Course::find($progcour->course_id);
                                        $department = Department::find($course->department_id);
                                        ?>
                                        <tr class="gradeA">
                                            <td class="center"><a href="/admin/course/view/{{$course->id}}">{{$course->title}}</a></td>

                                            <td class="center"><a href="/admin/department/view/{{$course->department_id}}">{{$department->name}}</a></td>
                                 
                                            <td class="center">
                                                <a href="/admin/progcours/edit/{{$progcour->id}}">
                                                <button class="btn btn-primary" ><i class="fa fa-pencil-square-o"></i></button>
                                                </a>  
                                                <button class="btn btn-warning" type="button" data-toggle="modal" data-target="{{ '#delete_' . $progcour->id }}"  data-toggle="tooltip" data-placement="top"  title="Delete Course from Program" ><i class="fa fa-trash-o"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach

                                       
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                </div>
                <!-- /.col-lg-6-->
                               
                                <div class="col-lg-6">
                                    {{ Form::open(['role'=>'form','type' => 'POST', 'url' => '/admin/programs', 'files' => true]) }}
                                        
                                        <div class="form-group @if($errors->has('title')) has-error @endif">
                                            <label>Title:</label>
                                            @if($errors->has('title'))
                                            <label class="control-label" for="inputError">{{ $errors->first('title') }}</label>
                                            @endif
                                            {{ Form::text('title', Session::get('title'), array('class' => 'form-control','maxlength'=>'255')) }}          
                                        </div>
                                        <div class="form-group @if($errors->has('description')) has-error @endif">
                                            <label>Description:</label>
                                            @if($errors->has('description'))
                                            <label class="control-label" for="inputError">{{ $errors->first('description') }}</label>
                                            @endif
                                            {{ Form::textarea('description', Session::get('description'), array('class' => 'form-control', )) }}        
                                        </div>

                                        <center>
                                        <button type="submit" class="btn btn-default">Add</button>
                                        </center>
                                    {{ Form::close() }}
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
@section('dialogs')
    @foreach($programs as $program)
    <?php 
        $modalName = "delete";
        $message = "Are you sure you want to delete program {$program->name} ?";
    ?>
   
    <div class="modal fade" id="{{ $modalName . '_' . $program->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <b style="color:white;">Delete Program</b>
                </div>
                <div class="modal-body">
                    <font color="black">{{ $message }}</font>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn " data-dismiss="modal">Cancel</button>
                    <a href="/admin/programs/delete/{{$program->id}}" class="btn btn-warning" id="confirm">Delete </a>
                </div>
            </div>
        </div>
    </div>         
    @endforeach
@stop
