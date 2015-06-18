
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
                            Departments
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
                                            <th>Name</th>
                                            <th>Professors</th>
                                            <th>Courses</th>
                                            <th>Controls</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($departments as $department)
                                        <?php
                                        $professors=DepProf::where("department_id", $department->id)->count();
                                        $courses = Course::where("department_id", $department->id)->count();
                                        ?>
                                        <tr class="gradeA">
                                            <td class="center"><a href="/admin/department/view/{{$department->id}}">{{$department->name}}</a></td>
                                            <td class="center">{{$professors}}</td>
                                            <td class="center">{{$courses}}</td>
                                            <td class="center">
                                                <a href="/admin/departments/edit/{{$department->id}}">
                                                <button class="btn btn-primary" ><i class="fa fa-pencil-square-o"></i></button>
                                                </a>  
                                                <button class="btn btn-warning" type="button" data-toggle="modal" data-target="{{ '#delete_' . $department->id }}"  data-toggle="tooltip" data-placement="top"  title="Delete Department" @if($professors!=0&&$courses!=0) disable @endif ><i class="fa fa-trash-o"></i></button>
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
    


                                    {{ Form::open(['role'=>'form','type' => 'POST', 'url' => '/admin/departments', 'files' => true]) }}
                                        
                                        
                                        <div class="form-group @if($errors->has('name')) has-error @endif">
                                            <label>Department Name:</label>
                                            @if($errors->has('name'))
                                            <label class="control-label" for="inputError">{{ $errors->first('name') }}</label>
                                            @endif
                                            {{ Form::text('name', Session::get('name'), array('class' => 'form-control','maxlength'=>'255')) }}          
                                        </div>
                                        <div class="form-group @if($errors->has('mission')) has-error @endif">
                                            <label>Department Mission:</label>
                                            @if($errors->has('mission'))
                                            <label class="control-label" for="inputError">{{ $errors->first('mission') }}</label>
                                            @endif
                                            {{ Form::textarea('mission', Session::get('mission'), array('class' => 'form-control', )) }}        
                                        </div>
                                        <div class="form-group @if($errors->has('vision')) has-error @endif">
                                            <label>Department Vision:</label>
                                            @if($errors->has('vision'))
                                            <label class="control-label" for="inputError">{{ $errors->first('vision') }}</label>
                                            @endif
                                            {{ Form::textarea('vision', Session::get('vision'), array('class' => 'form-control',)) }}   
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
    @foreach($departments as $department)
    <?php 
        $modalName = "delete";
        $message = "Are you sure you want to delete department {$department->name} ?";
    ?>
   
    <div class="modal fade" id="{{ $modalName . '_' . $department->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <b style="color:white;">Delete Department</b>
                </div>
                <div class="modal-body">
                    <font color="black">{{ $message }}</font>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn " data-dismiss="modal">Cancel</button>
                    <a href="/admin/departments/delete/{{$department->id}}" class="btn btn-warning" id="confirm">Delete </a>
                </div>
            </div>
        </div>
    </div>         
    @endforeach
@stop
