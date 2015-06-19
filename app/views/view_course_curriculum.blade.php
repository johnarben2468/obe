
@extends('layouts/index')

@section('header')
Course Curriculum
@stop

@section('content')
<?php

	 $alphabets   = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');



$institute = Institute::find(Auth::user()->institute_id);
$department = Department::find($course->department_id);
$program = Program::find($progcour->program_id);
?>
<div class="row">
	<div class="col-md-12">
    	<center>{{HTML::image($institute->header_file, 'logo')}}</center> 
		<br>
    	<div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Course Code</th>
                                            <th>Course Title</th>
                                            <th>Units/Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<tr>
                                    		@if($course->type=="LEC/LAB")
                                    		<td>{{$course->lec_code}} / {{$course->lab_code}}</td>
                                    		<td>{{ $course->title }}</td>
                                    		<td>{{$course->lec_units}} UNITS LEC / {{$course->lab_units}} UNITS LAB</td>
                                    		@elseif($course->type=="LEC")
                                    		<td>{{$course->lec_code}}</td>
                                    		<td>{{ $course->title }}</td>
                                    		<td>{{$course->lec_units}} UNITS LEC</td>
                                    		@elseif($course->type=="LAB")
                                    		<td>{{$course->lab_code}}</td>
                                    		<td>{{ $course->title }}</td>
                                    		<td>{{$course->lab_units}} UNITS LAB</td>
                                    		@endif
                                    	</tr>
                                    </tbody>
                    </table>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Institution Mission Statement</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<tr>
                                    		<td>{{$institute->mission}}</td>
                                    	</tr>
                                    </tbody>
                    </table>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Institution Vision Statement</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<tr>
                                    		<td>{{$institute->vision}}</td>
                                    	</tr>
                                    </tbody>
                    </table>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Department Mission Statement</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<tr>
                                    		<td>{{$department->mission}}</td>
                                    	</tr>
                                    </tbody>
                    </table>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Department Vision Statement</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<tr>
                                    		<td>{{$department->vision}}</td>
                                    	</tr>
                                    </tbody>
                    </table>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Department Vision Statement</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<tr>
                                    		<td>{{$department->vision}}</td>
                                    	</tr>
                                    </tbody>
                    </table>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Program Outcomes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<tr>
                                    		<td>
                                    			<ol type="a">
                                    				<?php
                                    				$programoutcomes = ProgramOutcome::where("program_id", $program->id)->get();
                                    				?>
                                    			  @foreach($programoutcomes as $programoutcome)
												  <li>{{$programoutcome->outcome}}</li>
												  @endforeach
												</ol>
                                    		</td>
                                    	</tr>
                                    </tbody>
                    </table>
                    </table><table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Course Learning Outcomes</th>
                                           
                                    				<?php
                                    				$programoutcomes = ProgramOutcome::where("program_id", $program->id)->get();
                                    				?>
                                    			  @foreach($programoutcomes as $key => $programoutcome)
												  <th>
												  	{{strtolower($alphabets[$key])}}
												  </th>
												  @endforeach
									
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
                                    				$courseoutcomes = CourseOutcome::where("course_id", $course->id)->get();
                                    				?>
                                    	@foreach($courseoutcomes as $coursekey => $courseoutcome)
                                    	<tr>
                                    		<th>
												  {{$coursekey+1}}. {{$courseoutcome->outcome}}
                                    		</th>
                                    		@foreach($programoutcomes as $key => $programoutcome)
												  <td>
												  	<?php $checkprogcour = ProgCourOutcome::where('program_outcome_id', $programoutcome->id)->where('course_outcome_id', $courseoutcome->id)->count(); ?>
												  	@if($checkprogcour!=0)
												  	x
												  	@endif
												  </td>

											 @endforeach

                                    	</tr>
                                    	@endforeach
                                    </tbody>
                    </table>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    
                                    <tbody>
                                    	<tr>
                                    		<th>Course Description</th>
                                    		<td>{{$course->description}}</td>
                                    	</tr>
                                    	<tr>
                                    		<th>Course Objectives</th>
                                    		<td>{{$course->objectives}}</td>
                                    	</tr>
                                    </tbody>
                    </table>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Week</th>
                                            <th>Topics</th>
                                            <th>Teaching and Learning Activities </th>
                                            <th>Assestment Task</th>
                                            <th>CLO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
                                    	
										$weeks = DB::table('topics')
	  									->where("course_id",$course->id)
            							->select(DB::raw('week_no as week_no'))
            							->groupBy('week_no')->orderBy('week_no', 'ASC')
            							->get();
   									
                                    	?>
                                    	@foreach($weeks as $week)
                                    	<?php
                                    	$topics = Topic::where("course_id",$course->id)->where("week_no",$week->week_no)->orderBy('title', 'ASC')->get();
                                    	?>
                                    	<tr>
                                    		<td>
                                    			{{$week->week_no}}
                                    		</td>
                                    		<td>
                                    			@foreach($topics as $topic)
                                    			{{$topic->title}}
                                    			<br>
                                    			@endforeach
                                    		</td>
                                    		<td></td>
                                    		<td></td>
                                    		<td>
                                    			@foreach($topics as $topic)
                                    			
                                    			 
                                    		


                   		 				@foreach($courseoutcomes as $coursekey => $courseoutcome)
                                    				<?php
												  	$clocheck = CLOTopic::where("topic_id", $topic->id)->where("course_outcome_id",$courseoutcome->id)->count();
												  	?>
												  	@if($clocheck!=0)
												  	{{$coursekey+1}}
												  	@endif
												 
												  	&nbsp;
											
                                    	@endforeach
                                    	


                                    			<br>
                                    			@endforeach
                                    		</td>
                                    	</tr>
                                    	@endforeach
                                    </tbody>
                    </table>
        </div>
    </div>
</div>
@stop