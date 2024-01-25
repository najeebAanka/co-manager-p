@extends('layout')
@section('content')
    <?php $u = \App\Models\User::find(Route::input('user_id'));
    
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header"><span id="user-name-header">{{ $u->name }}</span>
                        <span id="eval_span" style="color: green;">
                            <?php 
                                
                                $standards = \App\Models\EvalStandard::get();
                                $standardIds = $standards->count();
        
                                $evaluation_results = \App\Models\Evaluation::where('eval_to', $u->id)->orderBy('id', 'desc')->get()->take($standardIds);
        
                                $sum = 0;
        
                               foreach($evaluation_results as $evaluation_result){
                                  $sum += $evaluation_result->current_score;
                               }
        
                               $final_result = number_format(($sum/($standardIds*5))*100, 2);
        
                               echo '(' . $final_result . '%)';
                                
                                
                            ?>
                        </span>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif


                        <div></div>
                        <div class="row">

                            <div class="col-md-3 text-center">
                                <a href="{{ url('user-todo/' . $u->department_id . '/' . $u->id) }}">
                                    <div>
                                        <i class="fa fa-hourglass-half f-cnter" style="color: #666666"></i>
                                        <p style="color: black;"><?= App\Models\TodoJob::where('assigned_to', $u->id)
                                                ->where('current_status', 'to-do')
                                                ->count() ?> {{ __('general.todo_tasks') }}</p>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 text-center">
                                <a href="{{ url('user-inprogress/' . $u->department_id . '/' . $u->id) }}">
                                    <div>
                                        <i class="fa fa-clock f-cnter" style="color: #ff9933"></i>
                                        <p style="color: black;"><?= App\Models\TodoJob::where('assigned_to', $u->id)
                                                ->where('current_status', 'in-progress')
                                                ->count() ?> {{ __('general.in_progress_tasks') }}</p>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 text-center">
                                <a href="{{ url('user-done/' . $u->department_id . '/' . $u->id) }}">
                                    <div>
                                        <i class="fa fa-check f-cnter" style="color: #009933"></i>
                                        <p style="color: black;"><?= App\Models\TodoJob::where('assigned_to', $u->id)
                                                ->where('current_status', 'done')
                                                ->count() ?> {{ __('general.completed_tasks') }}</p>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 text-center">
                                <a href="{{ url('user-task-updates/' . $u->department_id . '/' . $u->id) }}">
                                    <div>
                                        <i class="fa fa-stream f-cnter" style="color: #009999"></i>
                                        <p style="color: black;">
                                            <?= App\Models\JobUpdate::where('created_by', $u->id)->count() ?>
                                            {{ __('general.task_updates') }}</p>
                                    </div>
                                </a>
                            </div>









                        </div>

                        <div>

                            <hr />
                            <form>

                                <div style="margin-top: 1rem; color: green; font-weight: bold;" id='errors-list'></div>
                                <div class="m-2 mb-4" style="color: brown; font-weight: bold; font-size: larger;">
                                    {{ __('general.profile') }}
                                </div>
                                <div class="form-row">



                                    <div class="form-group col-md-3">
                                        <label for="inputEmail4">{{ __('login.name') }}</label>
                                        <input type="text" class="form-control" value="{{ $u->name }}"
                                            id="in-name" placeholder="{{ __('login.name') }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputEmail4">{{ __('login.email') }}</label>
                                        <input type="text" class="form-control" value="{{ $u->email }}"
                                            id="in-email" placeholder="{{ __('login.email') }}">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputState">{{ __('login.department') }}</label>
                                        <select id="in-dep-id" class="form-control" disabled>
                                            <option value="-1">{{ __('general.select_department') }}</option>
                                            <?php foreach (\App\Models\Department::get() as $d){ ?>
                                            <option value="{{ $d->id }}"
                                                {{ $d->id == $u->department_id ? 'selected' : '' }}>
                                                {{ $d->getNameLocalized() }}</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputAddress2">{{ __('general.designation') }}</label>
                                        <input type="text" class="form-control" id="in-designation"
                                            placeholder="CEO ,CCO.." value="{{ $u->designation }}">
                                    </div>


                                </div>

                                <button type="button" onclick="_saveEditions(this)"
                                    class="btn btn-primary">{{ __('general.save_changes') }}</button>

                            </form>



                            <hr />
                            <form id="eval_form">

                                <div class="m-2 mb-4" style="color: brown; font-weight: bold; font-size: larger;">
                                    {{ __('general.evaluation') }}
                                </div>

                                <div class="form-row">


                                    <?php $evaluation_standards = \App\Models\EvalStandard::get(); foreach($evaluation_standards as $evaluation_standard){ ?>
                                    <div class="form-group col-md-3">

                                        <label for="inputState">{{ $evaluation_standard->getNameLocalized() }}</label>
                                        <select <?php if($u->id == Auth::id()) echo 'disabled';?> name="current_score[]" data-id="<?php echo $evaluation_standard->id; ?>"
                                            id="in-eval-<?php echo $evaluation_standard->id; ?>" class="form-control">
                                            {{-- <option disabled selected hidden value="-1">{{ __('general.no_option_selected') }}</option> --}}
                                            <?php for($i=1; $i<=5; $i++){ ?>
                                            <option value="{{ $i }}" <?php
                                            $evaluation = \App\Models\Evaluation::where('standard_id', $evaluation_standard->id)
                                                ->where('eval_to', $u->id)
                                                ->orderBy('id', 'desc')
                                                ->first();
                                            
                                            if ($evaluation && $evaluation->current_score == $i) {
                                                echo 'selected';
                                            }
                                            ?>>
                                                {{ $i }}
                                            </option>
                                            <?php } ?>
                                        </select>

                                        <input type="hidden" name="standard_id[]" value="<?php echo $evaluation_standard->id; ?>">

                                    </div>
                                    <?php } ?>

                                    <input type="hidden" name="eval_to" value="<?php echo \App\Models\User::find(Route::input('user_id'))->id; ?>">

                                    <input type="hidden" name="eval_by" value="<?php echo \App\Models\User::find(Auth::id())->id; ?>">

                                    <div class="form-group col-md-12">
                                        <label for="inputEmail4">{{ __('general.eval_notes') }}</label>

                                        {{-- <input type="text" class="form-control" value="<?php if ($evaluation) {
                                            echo $evaluation->notes;
                                        } ?>"
                                            name="notes" placeholder="{{ __('general.eval_notes') }}"> --}}

                                            <textarea <?php if($u->id == Auth::id()) echo 'disabled';?> class="form-control" name="notes" placeholder="{{ __('general.eval_notes') }}" rows="3"><?php if ($evaluation) {
                                                echo $evaluation->notes;
                                            } ?></textarea>
                                    </div>

                                </div>

                                <button <?php if($u->id == Auth::id()) echo 'hidden disabled';?> type="button" onclick="_submitEval(this)"
                                    class="btn btn-primary">{{ __('general.save_changes') }}</button>

                            </form>

                            <hr />


                            {{-- <form>
 
 
  <div class="form-row">
      
      
 
      
          <div class="form-group col-md-3">
      <label for="inputState">{{__('general.role')}}</label>
      <select id="in-role-id" class="form-control">
             <option value="-1">{{__('general.no-roles')}}</option>
         <?php foreach(DB::select("select * from roles") as $role){ ?>
          <option value="{{$role->id}}" <?= $u->hasRole($role->name) ? 'selected' : '' ?>>{{ $role->name}}</option>
          <?php } ?>
      </select>
    </div>
    
   
  </div>
  
                            <button type="button" onclick="_changeUserRole(this)" class="btn btn-primary">{{__('general.save_changes')}}</button>
                          
                        </form>        --}}
                        </div>

                        {{-- <hr /> --}}






                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function _saveEditions(c) {
            $(c).html("{{ __('general.saving') }}...");
            c.disabled = true;

            if (<?php echo $u->department_id; ?> != document.getElementById('in-dep-id').value) {
              alert('You are not authorized to change employee department!');
              $(c).html('<?php echo __("general.save_changes"); ?>');
              $('#in-dep-id').val('<?php echo $u->department_id ?>');
              $('#in-dep-id').attr('disabled', true);
              c.disabled = false;
              return;
            }

            $.ajax({
                url: '{{ url('ops/account/editByDM') }}',
                data: {
                    user_id: {{ $u->id }},
                    email: document.getElementById('in-email').value,
                    name: document.getElementById('in-name').value,
                    department: document.getElementById('in-dep-id').value,
                    designation: document.getElementById('in-designation').value
                },
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    c.disabled = false;
                    $(c).html("{{ __('general.save_changes') }}");

                    if (data.status) {
                        $("#user-name-header").html(document.getElementById('in-name').value);
                        $("#errors-list").html("{{ __('general.saved') }}");
                    } else {

                        $(".alert").remove();
                        $.each(data.errors, function(key, val) {
                            $("#errors-list").append("<div class='alert alert-danger'>" + val +
                                "</div>");
                        });
                    }

                }
            });
        }



        function _submitEval(c) {

            $(c).html("{{ __('general.saving') }}...");
            c.disabled = true;

            var formData = $('#eval_form').serialize(); // Serialize form data

            <?php
if ($u->id == Auth::id()) {
    echo "alert('You cannot evaluate yourself!'); c.hidden = true; $(c).html('" . __("general.save_changes") . "'); return;";
}
?>

            console.log(formData)

            $.ajax({
                url: '{{ url('ops/evaluations/addByDM') }}', // Update this URL according to your Laravel route
                type: 'POST',
                data: formData,
                success: function(data) {

                    c.disabled = false;
                    $(c).html("{{ __('general.save_changes') }}");
                    $('#eval_span').html('(' + data.final_eval + ')');
                    // $('#eval_form')[0].reset();

                    if (data.status) {
                        $("#errors-list").html("{{ __('general.saved') }}")
                    } else {
                        $('#eval_span').html('');

                        $(".alert").remove();
                        $.each(data.errors, function(key, val) {
                            $("#errors-list").append("<div class='alert alert-danger'>" + val +
                                "</div>");
                        });
                    }

                }
            });
        }



        // function _changeUserRole(c){
        //         $(c).html("{{ __('general.saving') }}...");
        //         c.disabled = true;

        //           $.ajax({
        //               url: '{{ url('ops/users/change-role') }}',
        //               data: { user_id : {{ $u->id }} ,  role_id : document.getElementById('in-role-id').value },
        //               type: "POST",
        //               dataType: 'json',
        //               success: function (data) {
        //   c.disabled = false;
        //                $(c).html("{{ __('general.save_changes') }}");

        //                 if (data.status) {
        //                    $("#errors-list").html("{{ __('general.saved') }}")
        //                 }else{

        //                     $(".alert").remove();
        //                     $.each(data.errors, function (key, val) {
        //                         $("#errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
        //                     });
        //                 }

        //               }
        //           });
        // }
    </script>
@endsection
