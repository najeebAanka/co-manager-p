@extends('layout')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header">{{__('general.departments')}}</div>
  
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
  
       
                    <div></div>
                    <div class="row">
<?php foreach (App\Models\Department::get() as $i){ ?>
                        <div class="col-md-4"><div class="sq-master department-btn" onclick="_({{$i->id}})">
                                
                                <i style="opacity: 0.5" class="fa fa-building"></i><br />
                                
                            <span style="color: #42809b; font-weight: bold;">    {{$i->getNameLocalized()}} <br /> </span>
                              {{-- {{$i->getNameLocalized()}} <br />  --}}
                                <i class="bn8975"><?= \App\Models\User::where('department_id' ,$i->id)->count()?> {{__('general.employee')}}</i>
                            </div></div>

<?php } ?>                        
                        
                    </div>     
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>

      
let _ = function(c){
    
    let target = c;
    console.log("cliked  : "+c);
    if(target != null){
location.href = "department-tasks/" +target;  
    }
   
};


</script>
@endsection