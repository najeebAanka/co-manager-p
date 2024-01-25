
    <?php 
    
    $done = App\Models\JobUpdate::where('job_id' ,$data->id)
                           ->sum('working_duration'); 
    $remaining = $data->duration_required - $done ?>

<style>
     .h{   background-color: green !important;
}
     .hv{   background-color:  #009900 !important ;
}
._cxz{
    background-color: #ffffbd;
    color: transparent;
}
._cxz:hover{
    background-color: #009900;
    cursor: pointer;
}
.viga td{
      height: 50px;
       transition: all 0.1s ease-in-out ;
}
 p#errors {
    padding: 5px;
    color: red;
    margin-top: 10px;
    background-color: #ffebeb;
}   


.table-container {
  overflow-x: auto; /* Enable horizontal scrolling when table exceeds parent width */
  max-width: 100%; /* Make sure the container doesn't exceed its parent's width */
}

/* CSS for the table */
.table-container table {
  width: 100%; /* Set the table width to 100% to ensure it adjusts to the container */
  border-collapse: collapse; /* Optional: Collapses borders for a cleaner look */
}


</style>

<div style="display: <?= $data->description != null || $data->description != '' ? 'block' : 'none' ;?>">
  <label for="validationDefault02"><h5>{{ __('general.task_description') }}</h5></label>
  <p><?= $data->description;?></p>
</div>

<button class="btn btn-success" onclick="$('#hh90763').show()" style="float: <?= app()->getLocale() == "ar" ? "left" : "right"?>">
    <i class="fa fa-plus"></i> {{ __('general.add_new_update') }}</button>
<h5>{{ __('general.progress') }} ({{number_format($done*100/$data->duration_required ,2)}}%)</h5>


<div style="height: 5px;"></div>
<div style="display: none" class="mb-4" id="hh90763">
<hr />
  <div class="form-row">
    <div class="col-md-12 mb-3">
      <label for="validationDefault02">{{ __('general.update_on_task') }}</label>
      <input type="text" id='notes' class="form-control"  placeholder="{{ __('general.notes_of_progress') }}.." required>
    </div>
        <div class="col-md-12 mb-3">
      <label for="validationDefault02">{{ __('general.time_consumed') }}</label>
      <p id="info-s" >{{ __('general.hover_to_pick_time') }}</p>

      <div class="table-container">
      <table style="width: 100%">
          <tr class="viga" onmouseout="document.getElementById('info-s').innerHTML='{{ __('general.hover_to_pick_time') }}';$('._cxz').removeClass('hv')">
    <?php
    $step = 1;
    if($remaining >  380) $step = 5;
    if($remaining >  1800) $step = 10;
    if($remaining >  3840) $step = 30;
    if($remaining >  11500) $step = 45;
    if($remaining >  16800) $step = 60;
    if($remaining >  28000) $step = 90;
    if($remaining >  34560) $step = 120;
    if($remaining >  46200) $step = 180;
    
    ?>
              @for($i=0;$i<= $remaining;$i+=$step)
          <td class="_cxz" id="_cxz{{$i}}" onclick='_hilit({{$i}})' onmouseover="_hilitC({{$i}})"  > </td>
          @endfor
          </tr>
      </table>
    </div>
      <p id="info" style="color: green;
    font-weight: bold;
    margin-top: 1rem;">{{ __('general.duration_not_set') }}</p>
      <span id="hidden-min-val" style="display: none">0</span>
    </div>
  
  </div>
<button class="btn btn-primary" type="button" onclick="_addTaskUpdate({{$data->id}} ,this)">{{ __('general.add_update') }}</button>
<button class="btn btn-secondary" type="button" onclick="$('#hh90763').hide()">{{ __('general.close') }}</button>
<p id="errors" style="display: none"></p>
</div>


<div id="task-updates-container">
    
               <div class="text-center p-5"><h4>{{ __('general.loading_data') }}</h4><p>{{ __('general.plz_wait') }}</p></div>
    
</div>


