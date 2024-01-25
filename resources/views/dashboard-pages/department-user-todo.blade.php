@extends('layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header">{{ __('general.todo_tasks') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif


                    <div></div>
                    <div class="row">


                     

                        <?php $todos = \App\Models\TodoJob::where('assigned_to', Route::input('user_id'))->where('current_status' ,'to-do')->orderBy('id' ,'desc')->paginate(10);
 foreach ($todos as $todo){
                        ?>

        <div class="col-md-4 text-center">
                <div class="user-card bg-white m-2 p-4">
                    {{-- <div class="profile-icon"> --}}
                        <i class="fa fa-hourglass-half f-cnter" style="color: #666666"></i>
                    {{-- </div> --}}
                    <p class="user-info">
                        <span class="user-name">{{$todo->title}}</span><br>
                        <span class="user-dept-name"><i>{{$todo->assigned_at}}</i></span>
                    </p>
                </div>
        </div>
                            
 <?php } ?>

                       



                    </div>
 <div class="m-2">
                {!!  $todos ->links() !!}
            </div>


                </div>
            </div>
        </div>
    </div>
</div>







@endsection

@section('js')

@endsection