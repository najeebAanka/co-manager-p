@extends('layout')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header">{{__('general.permissions')}}</div>
  
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
  
       
                    <div></div>
             
    <section class="section dashboard">
        
        <?php
        
        // $roles = DB::select("select * from roles");
        $roles = \App\Models\Role::get();
        $perms = DB::select("select * from permissions");
        ?>
        
      <div class="row">
          <div class="col-12">
              {{-- <table class="table table-bordered bg-white"  >
                  <tr>
                      <th></th>
                      
                      <?php foreach($roles as $role){ ?>

                      <th style="text-align: center;">{{$role->name}}</th>
                      <?php } ?>                      
                      
                  </tr>   
                  <?php foreach ($perms as $p){ ?>
                  <tr>
                      <td>{{__('general.'.$p->name)}}</td>
                  
                      <?php foreach($roles as $role){ ?>

                      <td style="text-align: center;"><input class="custom-checkbox" onchange="changePRbinding({{$role->id}},{{$p->id}} ,this)" <?=DB::select("select count(*) as c from role_has_permissions where role_id=? "
                              . "and permission_id=?" ,[$role->id ,$p->id])[0]->c>0 ? "checked" : ""?> type="checkbox" /></td>
                      <?php } ?>  
                  </tr>
                  <?php } ?>
                  
              </table>      --}}


              <table class="custom-table">
                <tr>
                    <th></th>
                    <?php foreach($roles as $role) { ?>
                        {{-- <th>{{$role->name}}</th> --}}
                        <th>{{$role->getNameLocalized();}}</th>
                    <?php } ?>
                </tr>
            
                <?php foreach($perms as $p) { ?>
                    <tr>
                        <td>{{__('general.'.$p->name)}}</td>
                        <?php foreach($roles as $role) { ?>
                            <td>
                                <input class="custom-checkbox"
                                       onchange="changePRbinding({{$role->id}},{{$p->id}}, this)"
                                       <?=DB::select("select count(*) as c from role_has_permissions where role_id=? "
                                              . "and permission_id=?", [$role->id, $p->id])[0]->c>0 ? "checked" : ""?>
                                       type="checkbox">
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>
              
              
          </div>
        
            </div>     


    </section>

    
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>

      
function changePRbinding(role ,perm ,c){
   c.disabled =true;
   
   
       $.ajax({
            type:'POST',
                    url:"{{url('ops/roles-and-permission/change-single')}}",
                    data:{"role_id" :  role, "perm_id" :perm, "status" : c.checked ? 1 : 0 },
                    success:function(data){
 c.disabled =false;
                    }
            });
   
   
    
}


</script>
@endsection