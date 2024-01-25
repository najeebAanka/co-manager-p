@extends('layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header">{{ __('general.task_updates') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif


                    <div></div>
                    <div class="row">


                     

                        <?php $jobUpdates = \App\Models\JobUpdate::where('created_by', Route::input('id'))->orderBy('id' ,'desc')->paginate(10);
 foreach ($jobUpdates as $jobUpdate){
    $job = \App\Models\TodoJob::where('id', $jobUpdate->job_id)->first();

    $jobUpdate->duration = floor($jobUpdate->working_duration/60).__('general.h')." ".($jobUpdate->working_duration%60).__('general.m');
    $jobUpdate->progress = number_format(\App\Models\JobUpdate::where('job_id' ,$job->id)
                   ->where('id' ,'<=' ,$jobUpdate->id)->sum('working_duration')/  $job ->duration_required * 100.0 ,2)." %";
                        ?>

        <div class="col-md-4 text-center">
                <div class="user-card bg-white m-2 p-4">
                    {{-- <div class="profile-icon"> --}}
                        <i class="fa fa-stream f-cnter" style="color: #009999"></i>
                    {{-- </div> --}}
                    <p class="user-info">
                        <span class="user-name">{{$job->title}}</span><br>
                        <span style="text-decoration: underline;">{{$jobUpdate->notes}}</span><br>
                        <span style="color: brown;">{{$jobUpdate->duration}}</span><br>
                        <span style="color: green;">{{$jobUpdate->progress}}</span><br>
                        <span class="user-dept-name"><i>{{$jobUpdate->created_at}}</i></span>
                    </p>
                </div>
        </div>
                            
 <?php } ?>

                       



                    </div>
 <div class="m-2">
                {!!  $jobUpdates ->links() !!}
            </div>


                </div>
            </div>
        </div>
    </div>
</div>







@endsection

@section('js')

@endsection