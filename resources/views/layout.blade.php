<!DOCTYPE html>
<?php
$lang = app()->getLocale();
$direction = $lang == 'ar' ? "rtl" : "ltr";
$alignment = $lang == 'ar' ? "right" : "left";

$u333 = Auth::user();

?>
<html lang="ar">
    <head>
        <title>{{ __('general.app-name') }}</title>
<link rel="icon" href="{{url('assets/img/fav.png')}}"/>    
<meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        @include('shared.css')
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light " style="background: rgb(255,255,255);
             background: -moz-linear-gradient(270deg, #ffffff8c 0%, #fff 50%, #ffffff8c 100%);
             background: -webkit-linear-gradient(270deg, #ffffff8c 0%, #fff 50%, #ffffff8c 100%);
             background: linear-gradient(270deg, #ffffff8c 0%, #fff 50%, #ffffff8c 100%);
             filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ffffff",endColorstr="#ffffff",GradientType=1);">
            <div class="container">


                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">




                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link text-center ml-2 mr-2" href="{{ url('') }}">
                                <img src="{{url('assets/icons/icons8-home-100.png')}}" style="width: 40px" /><br />
                                {{__('general.home')}}</a>
                        </li> 
                        @guest
                        <li class="nav-item">
                            
                            <a class="nav-link text-center ml-2 mr-2" href="{{ route('login') }}">
                                 <img src="{{url('assets/icons/icons8-lock-100.png')}}" style="width: 40px" /><br />
                                {{__('login.login')}}</a>
                        </li>
                        <li class="nav-item">
                             <a class="nav-link text-center ml-2 mr-2" href="{{ route('register') }}">
                                   <img src="{{url('assets/icons/icons8-key-100.png')}}" style="width: 40px" /><br />
                                 {{__('login.signup')}}</a>
                        </li>
                        @else
    @can('manage-departments')
                        <li class="nav-item ">
                            
                            <a class="nav-link text-center ml-2 mr-2" href="{{ url('departments') }}">
                                     <img src="{{url('assets/icons/icons8-toolbox-100.png')}}" style="width: 40px" /><br />
                                {{__('general.departments')}}</a>
                        </li> 
                        @endcan
                        @can('manage-permissions')
                        <li class="nav-item ">
                             
                            <a class="nav-link text-center ml-2 mr-2" href="{{ url('roles-and-permissions') }}">
                                   <img src="{{url('assets/icons/icons8-key-100.png')}}" style="width: 40px" /><br />
                                {{__('general.permissions')}}</a>
                        </li> 
                        @endcan
                        @role('Employee')
                        <li class="nav-item">
                              
                            <a class="nav-link  text-center ml-2 mr-2" href="{{ url('user-assigned-tasks') }}">
                                  <img src="{{url('assets/icons/icons8-news-100.png')}}" style="width: 40px" /><br />
                                {{__('general.user-assigned-tasks')}}</a>
                        </li> 
                        @endrole

                        @role('Department Manager')
                        @can('manage-his-department-tasks')
                        <li class="nav-item">
                              
                            <a class="nav-link  text-center ml-2 mr-2" href="{{ url('my-department-tasks'.'/'.$u333->department_id) }}">
                                  <img src="{{url('assets/icons/icons8-news-100.png')}}" style="width: 40px" /><br />
                                {{__('general.department-tasks')}}</a>
                        </li> 
                        @endcan
                        @endrole

                        @role('Department Manager')
                        @can('manage-his-department-users')
                        <li class="nav-item">
                              
                            <a class="nav-link  text-center ml-2 mr-2" href="{{ url('my-department-users'.'/'.$u333->department_id) }}">
                                  <img src="{{url('assets/icons/icons8-contacts-100.png')}}" style="width: 40px" /><br />
                                {{__('general.users')}}</a>
                        </li> 
                        @endcan
                        @endrole
                        
                        @can('manage-users')
                        <li class="nav-item ">
                            
                            <a class="nav-link text-center ml-2 mr-2" href="{{ url('users') }}">
                                    <img src="{{url('assets/icons/icons8-contacts-100.png')}}" style="width: 40px" /><br />
                                {{__('general.users')}}</a>
                        </li> 
                        @endcan

                        @role('Employee|Department Manager')
                        <li class="nav-item">
                              
                            <a class="nav-link  text-center ml-2 mr-2" href="{{ url('evaluations') }}">
                                  <img src="{{url('assets/icons/evaluation.png')}}" style="width: 40px" /><br />
                                {{__('general.evaluations')}}</a>
                        </li> 
                        @endrole

                        <li class="nav-item ">
                            
                            <a class="nav-link text-center ml-2 mr-2" href="{{ url('profile') }}">
                                    <img src="{{url('assets/icons/my-account-icon-png-15.png')}}" style="width: 40px" /><br />
                                {{__('general.profile')}}</a>
                        </li> 


                        @endguest





                    </ul>

                </div>
            </div>
        </nav>
        <div style="    min-height: 95vh;">
            @yield('content')
        </div>




        <div  style="background: rgb(255,255,255);margin-top: 2rem;
              background: -moz-linear-gradient(270deg, #ffffff8c 0%, #fff 50%, #ffffff8c 100%);
              background: -webkit-linear-gradient(270deg, #ffffff8c 0%, #fff 50%, #ffffff8c 100%);
              background: linear-gradient(270deg, #ffffff8c 0%, #fff 50%, #ffffff8c 100%);
              filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ffffff",endColorstr="#ffffff",GradientType=1);">
            <div class="container text-center p-3">
                <img src="{{url('assets/img/logo-lg.png')}}" alt="Logo" style="width:30px;">

                <div class="bs-example">

                    <p>{{ __('general.copy_rights_reserved') }} ©</p>




                    <div style="direction: ltr">
               


                    @if(auth()->check())     
                    {{Auth::user()->name}} | <!-- Dropdown -->
                    <a  href="{{ route('logout') }}">{{__('login.logout')}}</a> |      @if(app()->getLocale() == 'ar')

                    <a  href="{{ url('set-lang/en') }}">English</a>     

                    @else


                    <a  href="{{ url('set-lang/ar') }}">Arabic</a>        

                    @endif
                    @endif
                    </div>










                </div>
            </div>

        </div>





        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha512-n6dYFOG599s4/mGlA6E+YLgtg9uPTOMDUb0IprSMDYVLr0ctiRryPEQ8gpM4DCMlx7M2G3CK+ZcaoOoJolzdCg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
let work_hours = 8;
        </script>
        @yield('js')

    </body>
</html>