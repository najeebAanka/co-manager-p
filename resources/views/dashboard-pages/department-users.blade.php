@extends('layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header">{{ __('general.users') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif


                    <div></div>
                    <div class="row">


                     

                        <?php $users = \App\Models\User::where('department_id', Route::input('id'))->orderBy('id' ,'desc')->paginate(10);
 foreach ($users as $u){
                        ?>
   {{-- <div class="col-md-4 text-center">
       <a style="text-decoration: none;color: #000" href="{{url('user-details/'.$u->id)}}"><div class="bg-white m-2 p-2 pt-5">
       <i class="fa fa-user"  style="    background-color: #ededed;
    width: 100px;
    height: 100px;
    margin-bottom: 10px;
    border-radius: 50%;
    font-size: 50px;
    line-height: 100px;
    color: #ccc;" ></i>
       <p><span class="user-name">{{$u->name}}</span>
           <br /><span class="user-dept-name"><?= $u->department_id && $u->department_id!=-1 ?  \App\Models\Department::find($u->department_id)->getNameLocalized() : "?" ?></span></p>
       </div></a> 
        </div> --}}

        <div class="col-md-4 text-center">
            <a style="text-decoration: none;color: #000" href="{{url('user-details/'.$u->department_id.'/'.$u->id)}}">
                <div class="user-card bg-white m-2 p-4">
                    <p style="text-align: end; color: green;">
                        <?php 
                            $evaluation_standards = \App\Models\EvalStandard::get();
                            $standards_count = $evaluation_standards->count();
                            $evaluation_results = \App\Models\Evaluation::where('eval_to', $u->id)->orderBy('id', 'desc')->get()->take($standards_count);
                            $sum = 0;
                            foreach($evaluation_results as $evaluation_result){
                             $sum += $evaluation_result->current_score;
                            }
                             $final_result = number_format(($sum/($standards_count*5))*100, 2);
                             echo $final_result.'%';
                        ?>
                    </p>
                    <div class="profile-icon">
                        {{-- <i class="fa fa-user"></i> --}}
                        <img width="115" height="115" src="{{$u->buildImage();}}" style="border-radius: 50%;" />
                    </div>
                    <p class="user-info">
                        <span class="user-name">{{$u->name}}</span><br>
                        {{-- <span class="user-dept-name" style="font-weight: bold;"><i>{{$u->department_id && $u->department_id!=-1 ?  \App\Models\Department::find($u->department_id)->getNameLocalized() : "?"}}</i></span><br> --}}
                        <span class="user-dept-name"><i>{{$u->designation ?  $u->designation : "?"}}</i></span>
                    </p>
                </div>
            </a> 
        </div>
                            
 <?php } ?>

                       



                    </div>
 <div class="m-2">
                {!!  $users ->links() !!}
            </div>


                </div>
            </div>
        </div>
    </div>
</div>







@endsection

@section('js')

@endsection