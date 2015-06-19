
@extends('layouts/index')


@section('header')
    <?php
    $institute = Institute::find(Auth::user()->institute_id);
    echo $institute->name;
    $program = Program::find($progcour->program_id);
    $course = Course::find($progcour->course_id);
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
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{$program->title}} - {{$course->title}} Outcomes Settings
            </div>
            <div class="panel-body">
                {{ Form::open(['role'=>'form','type' => 'POST', 'url' => '/admin/programs/courses/settings']) }}

                <input type="hidden" name="prog_cour_id" value="{{$progcour->id}}">
                <div class="dataTable_wrapper">

                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Program Outcome</th>
                                            <th>Course Outcome</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($programoutcomes as $programoutcome)
                                        <?php
                                        
                                        $progcourcheck= ProgCourOutcome::where('prog_cour_id',$progcour->id)->where('program_outcome_id', $programoutcome->id)->count();
                                      
                                        if($progcourcheck!=0)
                                        {

                                            $progcouroutcome= ProgCourOutcome::where('prog_cour_id',$progcour->id)->where('program_outcome_id',$programoutcome->id)->first();
                            
                                            $courseoutcomecheck = CourseOutcome::find($progcouroutcome->course_id);
                                        }
                                        
                                        ?>
                                        <tr class="gradeA">
                                            <td class="center">{{$programoutcome->outcome}}</a></td>
                                            <td class="center">
                                                <select data-placeholder="Select course outcome" style="width:350px;"   class="chosen-select" tabindex="12" name="outcomes_{{$programoutcome->id}}">
                                                    <option value=""></option>

                                                @foreach($courseoutcomes as $courseoutcome)
                                                <option value="{{$courseoutcome->id}}"
                                                    @if($progcourcheck!=0)
                                                        @if($progcouroutcome->course_outcome_id==$courseoutcome->id)
                                                            selected
                                                       @endif
                                                    @endif
                                                    >{{$courseoutcome->outcome}}</option>
                                                @endforeach
                                            </select>   
                                            </td>
                                            
                                 
                                            
                                        </tr>
                                        @endforeach

                                       
                                    </tbody>
                    </table>
                </div>
                            <!-- /.table-responsive -->
                            <center>
                                        <button type="submit" class="btn btn-default">Save</button>
                                        </center>
                {{Form::close()}}
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    
             
</div>
<!-- /.row -->

@stop
@section('dialogs')
    
@stop
