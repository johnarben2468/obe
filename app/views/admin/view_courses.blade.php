
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
                {{$course->title}} Topics
            </div>
            <div class="panel-body">
                           
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Week</th>
                                            <th>Topic</th>
                                            <th>Controls</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($topics as $topic)
                                        
                                        <tr class="gradeA">
                                            <td class="center">{{$topic->week_no}}</td>

                                            <td class="center"><a href="/admin/topics/view/{{$topic->department_id}}">{{$topic->title}}</a></td>
                                 
                                            <td class="center">
                                            
                                                <button class="btn btn-warning" type="button" data-toggle="modal" data-target="{{ '#delete_' . $topic->id }}"  data-toggle="tooltip" data-placement="top"  title="Delete Topic" disabled><i class="fa fa-trash-o"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach

                                       
                                    </tbody>
                    </table>


                </div>
                            <!-- /.table-responsive -->

 
                {{ Form::open(['role'=>'form','type' => 'POST', 'url' => '/admin/courses/add/topic']) }}
                                        <div class="form-group @if($errors->has('title')) has-error @endif">
                                            <label>Add Topic:</label>
                                            @if($errors->has('title'))
                                            <label class="control-label" for="inputError">{{ $errors->first('title') }}</label>
                                            @endif
                                            {{ Form::text('title', Session::get('title'), array('class' => 'form-control','maxlength'=>'255')) }}          
                                        </div>

                                        
                                        <div class="form-group @if($errors->has('week_no')) has-error @endif">
                                            <label>Week No.:</label>
                                            @if($errors->has('week_no'))
                                            <label class="control-label" for="inputError">{{ $errors->first('week_no') }}</label>
                                            @endif
                                            <select data-placeholder="Select week" style="width:350px;" class="chosen-select" tabindex="12" name="week_no">
                                                <?php
                                                $weekcount = Topic::where("course_id",$course->id)->groupBy('week_no')->orderBy('week_no', 'DESC')->first();
    
                                                ?>
                                            <option select value="{{$weekcount->week_no+1}}">{{$weekcount->week_no+1}}</option>
                                            @foreach($weeks as $week)
                                            <option value="{{$week->week_no}}">{{$week->week_no}}</option>
                                            @endforeach
                                            </select>          
                                        </div>
                                        <div class="form-group @if($errors->has('clo')) has-error @endif">
                                            <label>Add Outcomes:</label>
                                            @if($errors->has('clo'))
                                            <label class="control-label" for="inputError">{{ $errors->first('clo') }}</label>
                                            @endif
                                            <select data-placeholder="Select course outcomes" style="width:350px;"  multiple class="chosen-select" tabindex="12" name="clo[]">
                                            @foreach($courseoutcomes as $courseoutcome)
                                            <option value="{{$courseoutcome->id}}">{{$courseoutcome->outcome}}</option>
                                            @endforeach
                                            </select>          
                                        </div>
                                        <input type="hidden" name="course_id" value="{{$course->id}}">
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
                {{$course->title}} Course Outcomes
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

                                        @foreach($courseoutcomes as $courseoutcome)
                                        <tr class="gradeA">
                                            <td class="center">{{$courseoutcome->outcome}}</td>
                                 
                                            <td class="center">
                                                
                                                <button class="btn btn-warning" type="button" data-toggle="modal" data-target="{{ '#deleteoutcome_' . $courseoutcome->id }}"  data-toggle="tooltip" data-placement="top"  title="Delete Outcome from Course" disabled><i class="fa fa-trash-o"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach

                                      
                                    </tbody>
                    </table>
                </div>
                 {{ Form::open(['role'=>'form','type' => 'POST', 'url' => '/admin/courses/add/outcome', 'files' => true]) }}
                                        
                                        <div class="form-group @if($errors->has('outcome')) has-error @endif">
                                            <label>Add Outcome:</label>
                                            @if($errors->has('outcome'))
                                            <label class="control-label" for="inputError">{{ $errors->first('outcome') }}</label>
                                            @endif
                                            {{ Form::text('outcome', Session::get('outcome'), array('class' => 'form-control','maxlength'=>'255')) }}          
                                        </div>
                                        <input type="hidden" name="course_id" value="{{$course->id}}">
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
    
    @foreach($topics as $topic)
    <?php 
        $modalName = "delete";
       
        $message = "Are you sure you want to delete topic {$topic->title} ?";

    ?>
   
    <div class="modal fade" id="{{ $modalName . '_' . $topic->id }}" aria-hidden="true">
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
                    <a href="/admin/topics/delete/{{$topic->id}}" class="btn btn-warning" id="confirm">Delete </a>
                </div>
            </div>
        </div>
    </div>         
    @endforeach
    @foreach($courseoutcomes as $courseoutcome)
    <?php 
        $modalName = "deleteoutcome";
     
        $message = "Are you sure you want to delete outcome for this course?";

    ?>
   
    <div class="modal fade" id="{{ $modalName . '_' . $courseoutcome->id }}" aria-hidden="true">
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
                    <a href="/admin/courses/outcome/delete/{{$courseoutcome->id}}" class="btn btn-warning" id="confirm">Delete </a>
                </div>
            </div>
        </div>
    </div>         
    @endforeach
@stop
