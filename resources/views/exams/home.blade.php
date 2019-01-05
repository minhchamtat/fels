@extends('exams.master')
@section('title', 'Home')
@section('content')
<div class="container">
	<div class="content container">
		<div class="col-md-12 width-flash">
		</div>
	</div>
	<div class="row exam">
		<div class="col-md-12">
			<div class="form-exam">
				@if(!Auth::check())
					die();
				@endif
				@if ($subjects->isEmpty())
               		 <p> There is no subject.</p>
           		@else
				<form class="new_exam" id="new_exam" action="/" accept-charset="UTF-8" method="post">
					@foreach ($errors->all() as $error)
						<p class="alert alert-danger">{{ $error }}</p>
					@endforeach
					@if (session('status'))
						<div class="alert alert-success">
						{{ session('status') }}
						</div>
					@endif
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="select-subject col-md-2">
					<select name="exam_subject" id="exam_subject_id">
						@foreach($subjects as $subject)
							<option value="{!! $subject->id !!}">{!! $subject->name_subject !!}</option>
						@endforeach
					</select>
				</div>
				@endif
				<input type="submit" name="commit" value="Create Exam" class="btn-create">
				</form>
			</div>
			<hr>
			<h3>List Of Exams</h3>
			<table class="table">
			<thead>
				<tr><th class="created_date">Created Date</th>
				<th class="subject">Subject</th>
				<th class="status-ff">Status</th>
				<th class="duration">Duration</th>
				<th class="question_number">Question number</th>
				<th class="spent_time">Spent Time</th>
				<th class="score">Score</th>
				<th class="action"></th></tr>
				<th class="nowrap"></th>
			</thead>
			<tbody>
				@if ($exams->isEmpty())
               		 <p> There is no exam.</p>
           		@else
				@foreach($exams as $exam)
					<tr>
					<td>{!! $exam->created_at !!}</td>
					<td>{!! $exam->name_subject !!}</td>
					<td class="status">
						{!! $exam->status !!}
					</td>
					<td>{!! $exam->duration !!}</td>
					<td>{!! $exam->question_number !!}</td>
					<td>@if(is_null($exam->spent_time))
								{{ '00:00:00' }}
						@endif
					</td>
					<td>@if($exam->status != 'checked' && $exam->status != 'unchecked')
							{{ '-' }}
					    @else {!! $exam->score !!}
						@endif
					</td>
					<td class="act">
						@if($exam->status == 'start' || $exam->status == 'testing')
							{{ 'Start' }}
						@else {{ 'View' }}
						@endif
						</a>
					</td>
					<td class="nowrap">{{ $exam->id }}</td>
					</tr>
				@endforeach
				@endif
			</tbody></table>
		</div>
	</div>
</div>
@endsection
@push('js')
    <script type="text/javascript">

    $(document).ready(function () {
    	let s = {
    		checked: {
    			name: "checked",
    			cls: "success"
    		},

    		unchecked: {
    			name: "unchecked",
    			cls: "info"
    		},

    		start: {
    			name: "start",
    			cls: "primary"
    		},

    		testing: {
    			name: "testing",
    			cls: "warning"
    		}
    	};

    	let a = {
    		Start: {
    			name: "Start",
    			cls: "primary"
    		},

    		View: {
    			name: "View",
    			cls: "success"
    		},
    	};

    	if($(".act").length)
    	{
    		$(".status").each(function( index, value ) {
	            let status = $(this).text().trim();
	            let html = '<span class="label label-'+s[status].cls+'">'+s[status].name+'</span>';
	            $(this).html(html);
	        });

        	$(".act").each(function( index, value ) {
	            let act = $(this).text().trim();
	            let id = $(this).closest('tr').find('td').last().text().trim();
	            let html = '<a class="btn btn-'+a[act].cls+' button" href="/exams/'+id+'">'+a[act].name;
	            $(this).html(html);
        	});
    	}
    });       
    </script> 
@endpush