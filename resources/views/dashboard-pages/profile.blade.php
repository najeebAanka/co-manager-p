@extends('layout')
@section('content')
    <?php $u = \App\Models\User::find(Auth::id());
    
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header"><span id="user-name-header">{{ $u->name }}</span>
                        <span id="eval_span" style="color: green;" <?php $admins = DB::select('select * from model_has_roles where role_id = 1'); foreach($admins as $admin){
                            if($u->id == $admin->model_id) echo 'hidden';
                          } ?>>
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

                    <div class="mt-3" style="text-align: center;"><img src="{{ $u->buildImage() }}" id="user-image"
                            width="300" /></div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif


                        <div></div>




                        <div>

                            <hr />
                            <form>

                                <div style="margin-top: 1rem; color: green; font-weight: bold;" id='errors-list'></div>
                                <div class="m-2 mb-4" style="color: brown; font-weight: bold; font-size: larger;">
                                    {{ __('general.profile') }}
                                </div>

                                <div class="form-row">



                                    <div class="form-group col-md-4">
                                        <label for="inputEmail4">{{ __('login.name') }}</label>
                                        <input type="text" class="form-control" value="{{ $u->name }}"
                                            id="in-name" placeholder="{{ __('login.name') }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputEmail4">{{ __('login.email') }}</label>
                                        <input type="text" class="form-control" value="{{ $u->email }}"
                                            id="in-email" placeholder="{{ __('login.email') }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputEmail4">{{ __('login.password') }}</label>
                                        <input type="password" class="form-control" id="in-password"
                                            placeholder="{{ __('login.password') }}">
                                    </div>




                                </div>

                                <button type="button" onclick="_saveEditions(this)"
                                    class="btn btn-primary">{{ __('general.save_changes') }}</button>

                            </form>
                            <hr />



                            
                            <div class="m-2 mb-4" style="color: brown; font-weight: bold; font-size: larger;">
                                {{ __('general.image') }}
                            </div>
                            <form enctype="multipart/form-data" id="image-submit-form">

                                <input type="hidden" value="{{ $u->id }}" name="user_id" >
                            
                                <div class="form-group col-md-4">
                                    {{-- <label for="inputImage">{{ __('general.image') }}</label> --}}
                                    <input type="file" class="form-control-file" id="inputImage" name="image">
                                </div>
                            
                                <button id="add-image-button" type="submit" class="btn btn-primary">{{ __('general.save_changes') }}</button>
                            </form>




                            
                            <form id="eval_form" <?php $admins = DB::select('select * from model_has_roles where role_id = 1'); foreach($admins as $admin){
                                if($u->id == $admin->model_id) echo 'hidden';
                              } ?>>
                                <hr />
                                <div class="m-2 mb-4" style="color: brown; font-weight: bold; font-size: larger;">
                                    {{ __('general.evaluation') }}
                                </div>

                                <div class="form-row">


                                    <?php $evaluation_standards = \App\Models\EvalStandard::get(); foreach($evaluation_standards as $evaluation_standard){ ?>
                                    <div class="form-group col-md-3">

                                        <label for="inputState">{{ $evaluation_standard->getNameLocalized() }}</label>
                                        <select disabled name="current_score[]" data-id="<?php echo $evaluation_standard->id; ?>"
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

                                    {{-- <input type="hidden" name="eval_to" value="<?php echo \App\Models\User::find(Route::input('user_id'))->id; ?>"> --}}

                                    {{-- <input type="hidden" name="eval_by" value="<?php echo \App\Models\User::find(Auth::id())->id; ?>"> --}}

                                    <div class="form-group col-md-12">
                                        <label for="inputEmail4">{{ __('general.eval_notes') }}</label>

                                        {{-- <input disabled type="text" class="form-control" value="<?php if ($evaluation) {
                                            echo $evaluation->notes;
                                        } ?>"
                                            name="notes" placeholder="{{ __('general.eval_notes') }}"> --}}

                                            <textarea disabled rows="3" class="form-control" name="notes" placeholder="{{ __('general.eval_notes') }}"><?php if ($evaluation) {
                                                echo $evaluation->notes;
                                            } ?></textarea>
                                    </div>

                                </div>

                                {{-- <button type="button" onclick="_submitEval(this)"
                                    class="btn btn-primary">{{ __('general.save_changes') }}</button> --}}

                            </form>




                        </div>

                        <hr />



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

            $.ajax({
                url: '{{ url('ops/profile/edit') }}',
                data: {
                    user_id: {{ $u->id }},
                    email: document.getElementById('in-email').value,
                    name: document.getElementById('in-name').value,
                    password: document.getElementById('in-password').value,

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




        $("#image-submit-form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#add-image-button").text("{{ __('general.saving') }}...");
                $("#add-image-button").attr('disabled', true);
                $.ajax({
                    url: '{{ url('ops/profile/editImg') }}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status) {
                            $("#user-image").attr('src', data.image);
                            $("#add-image-button").text("{{ __('general.save_changes') }}");
                            $("#add-image-button").attr('disabled', false);
                            $("#image-submit-form")[0].reset();
                        }

                        else {

                            $("#add-image-button").text("{{ __('general.save_changes') }}");
                            $("#add-image-button").attr('disabled', false);
                            $("#image-submit-form")[0].reset();

                            $(".alert").remove();
                            $.each(data.errors, function(key, val) {
                            $("#errors-list").append("<div class='alert alert-danger'>" + val +
                            "</div>");
                            });
                        }
                        
                    }


                });
            });






    </script>
@endsection
