@extends('layout')
    
@section('content')
<main class="login-form">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">        {{__('login.signup')}}</div>
                  <div class="card-body">
    
                      <form action="{{ route('register.post') }}" method="POST" id="handleAjax">
  
                          @csrf
 
                          <div id="errors-list"></div>
 
                          <div class="form-group row">
                              <label for="name" class="col-md-4 col-form-label text-md-right"> {{__('login.name')}}</label>
                              <div class="col-md-6">
                                  <input type="text" id="name" class="form-control" name="name" required autofocus>
                                  @if ($errors->has('name'))
                                      <span class="text-danger">{{ $errors->first('name') }}</span>
                                  @endif
                              </div>
                          </div>
    
                          <div class="form-group row">
                              <label for="email_address" class="col-md-4 col-form-label text-md-right"> {{__('login.email')}}</label>
                              <div class="col-md-6">
                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div>
                          </div>
    
                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right"> {{__('login.password')}}</label>
                              <div class="col-md-6">
                                  <input type="password" id="password" class="form-control" name="password" required>
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="form-group row">
                              <label for="confirm_password" class="col-md-4 col-form-label text-md-right"> {{__('login.confirm_password')}}</label>
                              <div class="col-md-6">
                                  <input type="password" id="confirm_password" class="form-control" name="confirm_password" required>
                                  @if ($errors->has('confirm_password'))
                                      <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                  @endif
                              </div>
                          </div>
                          
                          
                           <div class="form-group row">
                              <label for="confirm_password" class="col-md-4 col-form-label text-md-right"> {{__('login.department')}}</label>
                              <div class="col-md-6">
                                  <select id="department_id" name="department_id" class="form-control">
             <option value="-1">{{__('general.select_department')}}</option>
          <?php foreach (\App\Models\Department::get() as $d){ ?>
          <option value="{{$d->id}}"  >{{$d->getNameLocalized()}}</option>
          <?php } ?>
      </select>
                              </div>
                          </div>
     
    
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  {{__('login.signup')}}
                              </button>
                          </div>
                      </form>
                          
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
  @endsection


@section('js')
<script type="text/javascript">
  
  $(function() {
        
      /*------------------------------------------
      --------------------------------------------
      Submit Event
      --------------------------------------------
      --------------------------------------------*/
      $(document).on("submit", "#handleAjax", function() {
          var e = this;
  
          $(this).find("[type='submit']").html("{{__('login.signup')}}...");
  
          $.ajax({
              url: $(this).attr('action'),
              data: $(this).serialize(),
              type: "POST",
              dataType: 'json',
              success: function (data) {
  
                $(e).find("[type='submit']").html("{{__('login.signup')}}");
                  
                if (data.status) {
                    window.location = data.redirect;
                }else{
  
                    $(".alert").remove();
                    $.each(data.errors, function (key, val) {
                        $("#errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
                    });
                }
             
              }
          });
  
          return false;
      });
  
    });
  
</script>
@endsection