@extends('layout')
    
@section('content')
<main class="login-form">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">{{__('login.login')}}</div>
                  <div class="card-body">
    
                      <form action="{{ route('login.post') }}" method="POST" id="handleAjax">
                          @csrf
  
                          <div id="errors-list"></div>
  
                          <div class="form-group row">
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">{{__('login.email')}}</label>
                              <div class="col-md-6">
                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div>
                          </div>
     
                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">{{__('login.password')}}</label>
                              <div class="col-md-6">
                                  <input type="password" id="password" class="form-control" name="password">
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                              </div>
                          </div>
    
                      
    
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  {{__('login.login')}}
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
  
          $(this).find("[type='submit']").html("{{__('login.login')}}...");
  
          $.ajax({
              url: $(this).attr('action'),
              data: $(this).serialize(),
              type: "POST",
              dataType: 'json',
              success: function (data) {
  
                $(e).find("[type='submit']").html("{{__('login.login')}}");
  
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