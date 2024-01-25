@extends('layout')
  <?php
$lang = app()->getLocale();
$direction = $lang == 'ar' ? "rtl" : "ltr";
$alignment = $lang == 'en' ? "right" : "left";
?>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-5">
  
                <div class="card-body  ">
             
               <div style="color: #000">
                   <?php $u=Auth::user();$yes=false; foreach (DB::select("select * from roles") as $r){ if($u->hasRole($r->name))$yes = true;  } ?>
                
                   
                   @if($yes)
                     <img src="{{url('assets/img/Task-Mining-1-e1629696855260.png')}}" alt="Logo" style="width: 440px;float: {{$alignment}}; ">
      
                     <div style="margin-top: 4rem"></div>
                     {!!__('general.presentation_html') !!}
                     @else
                     
                     <div class="text-center p-4 m-5">
                         
                         <h4>{{__('general.welcome')}} {{$u->name}}</h4>
                         <p>{{__('general.plz_contact_to_get_assigned')}}</p>
                     </div>
                     
                     @endif
            </div>        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection