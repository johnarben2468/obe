
@extends('layouts/index')


@section('header')
    <?php
    $institute = Institute::find(Auth::user()->institute_id);
    echo $institute->name;
    ?>
@stop
@section('content')

    <!-- /.row -->
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
        <div class="panel panel-default">
            <div class="panel-heading">
                {{$program->title}} Program Course List
            </div>
            <div class="panel-body">
                           
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Course</th>
                                         
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
                                            <td class="center"><a href="/curriculum/courses/{{$progcour->id}}">{{$course->title}}</a></td>

                                            <td class="center">{{$department->name}}</td>
                                 
                                            <td class="center">
                                                <a href="/admin/programs/courses/settings/{{$progcour->id}}">

                                                <button class="btn btn-primary" >Set Outcomes</button>
                                                </a>  
                                                <a href="/admin/progcours/edit/{{$progcour->id}}">
                                                <button class="btn btn-primary" disabled ><i class="fa fa-pencil-square-o" ></i></button>
                                                </a>  
                                                <button class="btn btn-warning" type="button" data-toggle="modal" data-target="{{ '#delete_' . $progcour->id }}"  data-toggle="tooltip" data-placement="top"  title="Delete Course from Program" disabled><i class="fa fa-trash-o"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach

                                       
                                    </tbody>
                    </table>
                </div>
                            <!-- /.table-responsive -->

                {{ Form::open(['role'=>'form','type' => 'POST', 'url' => '/admin/programs/add/course']) }}
                                        
                                        <div class="form-group @if($errors->has('courses')) has-error @endif">
                                            <label>Add Courses:</label>
                                            @if($errors->has('courses'))
                                            <label class="control-label" for="inputError">{{ $errors->first('courses') }}</label>
                                            @endif
                                            <select data-placeholder="Select courses to add" style="width:350px;"  multiple class="chosen-select" tabindex="12" name="courses[]">
                                            @foreach($courses as $course)
                                            <option value="{{$course->id}}">{{$course->title}}</option>
                                            @endforeach
                                            </select>          
                                        </div>
                                        <input type="hidden" name="program_id" value="{{$program->id}}">
                                        <center>
                                        <button type="submit" class="btn btn-default">Add</button>
                                        </center>
                                    {{ Form::close() }}
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <div class="col-lg-6"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                {{$program->title}} Program Outcomes
            </div>
            <div class="panel-body">
                    <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Outcome</th>
                                            <th>Controls</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($programoutcomes as $programoutcome)
                                        <tr class="gradeA">
                                            <td class="center">{{$programoutcome->outcome}}</td>
                                 
                                            <td class="center">
                                                <button class="btn btn-warning" type="button" data-toggle="modal" data-target="{{ '#deleteoutcome_' . $programoutcome->id }}"  data-toggle="tooltip" data-placement="top"  title="Delete Outcome from Program" disabled><i class="fa fa-trash-o"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach

                                      
                                    </tbody>
                    </table>
                </div>
                {{ Form::open(['role'=>'form','type' => 'POST', 'url' => '/admin/programs/add/outcome', 'files' => true]) }}
                                        
                                        <div class="form-group @if($errors->has('title')) has-error @endif">
                                            <label>Add Outcome:</label>
                                            @if($errors->has('title'))
                                            <label class="control-label" for="inputError">{{ $errors->first('title') }}</label>
                                            @endif
                                            {{ Form::text('outcome', Session::get('outcome'), array('class' => 'form-control','maxlength'=>'255')) }}          
                                        </div>
                                        <input type="hidden" name="program_id" value="{{$program->id}}">
                                        <center>
                                        <button type="submit" class="btn btn-default">Add</button>
                                        </center>
                {{ Form::close() }}
            </div>
        </div>

    </div>
             
</div>
<!-- /.row -->

@stop
@section('dialogs')
    
    @foreach($progcours as $progcour)
    <?php 
        $modalName = "delete";
        $course = Course::find($progcour->course_id);
        $message = "Are you sure you want to delete course {$course->title} form this program?";

    ?>
   
    <div class="modal fade" id="{{ $modalName . '_' . $progcour->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <b >Delete </b>
                </div>
                <div class="modal-body">
                    <font color="black">{{ $message }}</font>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn " data-dismiss="modal">Cancel</button>
                    <a href="/admin/progcour/delete/{{$progcour->id}}" class="btn btn-warning" id="confirm">Delete </a>
                </div>
            </div>
        </div>
    </div>         
    @endforeach
    @foreach($programoutcomes as $programoutcome)
    <?php 
        $modalName = "deleteoutcome";
     
        $message = "Are you sure you want to delete outcome for this program?";

    ?>
   
    <div class="modal fade" id="{{ $modalName . '_' . $programoutcome->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <b >Delete </b>
                </div>
                <div class="modal-body">
                    <font color="black">{{ $message }}</font>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn " data-dismiss="modal">Cancel</button>
                    <a href="/admin/program/outcome/delete/{{$programoutcome->id}}" class="btn btn-warning" id="confirm">Delete </a>
                </div>
            </div>
        </div>
    </div>         
    @endforeach
@stop
