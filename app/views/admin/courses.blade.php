
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
                            Courses
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
                                            <th>Course Code</th>
                                            <th>Type</th>
                                           
                                            <th>Units</th>
                                            <th>Department</th>
                                            <th>Controls</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($courses as $course)
                                        <?php
                                        $department = Department::find($course->department_id);
                                        ?>
                                        <tr class="gradeA">
                                            <td class="center">
                                                <a href="/admin/courses/view/{{$course->id}}">
                                                @if($course->type=="LAB")
                                                {{$course->lab_code}}
                                                @elseif($course->type=="LEC")
                                                {{$course->lec_code}}
                                                @elseif($course->type=="LEC/LAB")
                                                {{$course->lec_code}}/{{$course->lab_code}}
                                                @endif
                                                </a>
                                            </td>
                                            <td class="center">{{$course->type}}</td>
                                            <td class="center">
                                                @if($course->type=="LAB")
                                                {{$course->lab_units}}
                                                @elseif($course->type=="LEC")
                                                {{$course->lec_units}}
                                                @elseif($course->type=="LEC/LAB")
                                                {{$course->lec_units}}/{{$course->lab_units}}
                                                @endif
                                            </td>
                                            <td class="center">{{$department->name}}</td>
                                            <td class="center">
                                                <a href="/admin/course/edit/{{$course->id}}">
                                                <button class="btn btn-primary" disabled><i class="fa fa-pencil-square-o"></i></button>
                                                </a>  
                                                <button class="btn btn-warning" type="button" data-toggle="modal" data-target="{{ '#delete_' . $course->id }}"  data-toggle="tooltip" data-placement="top"  title="Delete Course" disabled><i class="fa fa-trash-o"></i></button>
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
                                    {{ Form::open(['role'=>'form','type' => 'POST', 'url' => '/admin/courses', 'files' => true]) }}
                                        
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
                                        <div class="form-group @if($errors->has('objectives')) has-error @endif">
                                            <label>Objectives:</label>
                                            @if($errors->has('objectives'))
                                            <label class="control-label" for="inputError">{{ $errors->first('objectives') }}</label>
                                            @endif
                                            {{ Form::textarea('objectives', Session::get('objectives'), array('class' => 'form-control', )) }}        
                                        </div>
                                        <div class="form-group @if($errors->has('type')) has-error @endif">
                                            <label>Type:</label>
                                            @if($errors->has('type'))
                                            <label class="control-label" for="inputError">{{ $errors->first('type') }}</label>
                                            @endif
                                            <select data-placeholder="Select type" style="width:350px;"  class="chosen-select form-control" tabindex="12" name="type">
                        
                                            <option value="LEC">Lecture</option>
                                            <option value="LAB">Laboratory</option>
                                            <option value="LEC/LAB">Lecture/Laboratory</option>
                                            </select>          
                                        </div>
                                        <div class="form-group @if($errors->has('lec_code')) has-error @endif">
                                            <label>Lecture Code:</label>
                                            @if($errors->has('lec_code'))
                                            <label class="control-label" for="inputError">{{ $errors->first('lec_code') }}</label>
                                            @endif
                                            {{ Form::text('lec_code', Session::get('lec_code'), array('class' => 'form-control','maxlength'=>'255')) }}  
                                        </div>
                                        <div class="form-group @if($errors->has('lec_units')) has-error @endif">
                                            <label>Lecture Units:</label>
                                            @if($errors->has('lec_units'))
                                            <label class="control-label" for="inputError">{{ $errors->first('lec_units') }}</label>
                                            @endif
                                            {{ Form::number('lec_units', Session::get('lec_units'), array('class' => 'form-control','maxlength'=>'255')) }}  
                                        </div>
                                        <div class="form-group @if($errors->has('lab_code')) has-error @endif">
                                            <label>Laboratory Code:</label>
                                            @if($errors->has('lab_code'))
                                            <label class="control-label" for="inputError">{{ $errors->first('lab_code') }}</label>
                                            @endif
                                            {{ Form::text('lab_code', Session::get('lab_code'), array('class' => 'form-control','maxlength'=>'255')) }}  
                                        </div>
                                        <div class="form-group @if($errors->has('lab_units')) has-error @endif">
                                            <label>Laboratory Units:</label>
                                            @if($errors->has('lab_units'))
                                            <label class="control-label" for="inputError">{{ $errors->first('lab_units') }}</label>
                                            @endif
                                            {{ Form::number('lab_units', Session::get('lab_units'), array('class' => 'form-control','maxlength'=>'255')) }}  
                                        </div>
                                        <div class="form-group @if($errors->has('department')) has-error @endif">
                                            <label>Department:</label>
                                            @if($errors->has('department'))
                                            <label class="control-label" for="inputError">{{ $errors->first('department') }}</label>
                                            @endif
                                            <select data-placeholder="Select department" style="width:350px;"  class="chosen-select form-control" tabindex="12" name="department">
                                            @foreach($departments as $department)
                                            <option value="{{$department->id}}">{{$department->name}}</option>
                                            @endforeach
                                            </select>          
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
   @foreach($courses as $course)
    <?php 
        $modalName = "delete";
        $message = "Are you sure you want to delete course {$course->title} ?";
    ?>
   
    <div class="modal fade" id="{{ $modalName . '_' . $course->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <b style="color:white;">Delete Course</b>
                </div>
                <div class="modal-body">
                    <font color="black">{{ $message }}</font>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn " data-dismiss="modal">Cancel</button>
                    <a href="/admin/courses/delete/{{$course->id}}" class="btn btn-warning" id="confirm">Delete </a>
                </div>
            </div>
        </div>
    </div>         
    @endforeach
@stop
