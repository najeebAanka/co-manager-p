@extends('layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header"><a href="">{{ __('general.tasks') }}</a></div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif


                    <div></div>
                    <div class="row">


                        <div class="col-md-12">

                            <div class="mb-2" style="display: flex; align-items: center;">
                              <div class="col-md-11">
                                <input type="text" class="form-control" id="task-search" placeholder="{{ __('general.search_task_here_placeholder') }}" />
                              </div>
                              <div class="col-md-1">
                                <button class="btn btn-info" id="task-search-button" style="margin-left: 2px;"><i class="fa fa-search"></i></button>
                              </div>
                          </div>

                            <div id="tasks-container">
                                <div class="text-center p-5"><h4>{{ __('general.loading_data') }}</h4><p>{{ __('general.plz_wait') }}</p></div>
                            </div>


                        </div>



                    </div>



                </div>
            </div>
        </div>
    </div>
</div>





<!-- Modal -->
<div class="modal fade" id="TaskDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">---</h5>
        <button type="button" class="btn btn-light mr-1 ml-1" data-dismiss="modal">x</button>

      </div>
      <div class="modal-body">
       <div class="row">

           
           <div class="col-md-12" id="modal-heart">

                                <div class="text-center p-5"><h4>{{ __('general.loading_data') }}</h4><p>{{ __('general.plz_wait') }}</p></div>


                        </div>



                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary mr-1 ml-1" data-dismiss="modal">{{ __('general.close') }}</button>

      </div>
    </div>
  </div>
</div>

@endsection

@section('js')
<?php $users = \App\Models\User::where('department_id' ,Route::input('id'))->orderBy('name')->get(); ?>
<script>




function changeStatus(id ,c){
  _editTask({'id' : id ,'current_status' : c.value} ,c);
}



function buildTaskCard(task){

    let taskFileSpan = '';
  if (task.task_file) {
    taskFileSpan = '<span class="span-file" id="download-task-file-' + task.id + '"><a style="color: white;" href="' + task.task_file + '" target="_blank"><i class="fa fa-link"></i></a></span>';
  }

      let div = '<div class="task-row"  data-id="'+task.id+'"><div class="row"><div class="col-1 text-center"><i class="fa  fa-stream status-'+task.current_status+'-i"></i></div>\n\
<div class="col-5">\n\
<p title="'+task.title+'" class="task-text"   id="p-'+task.id+'">\n\
<span onclick="loadTaskDetails('+task.id+' ,this)" class="task-status-'+task.current_status+' spannable-link">'+
            task.title+'</span>'+task.progress_span+ taskFileSpan+'</p></div><div class="col-2" style="text-align: center;">'+task.assigned_at+'</div><div class="col-4 align-end"><select id="status-select-'+task.id+'" class="task-row-select" \n\
style="background : '+getStatusBgColor(task.current_status)+'"><option \n\
value="to-do" '+(task.current_status == "to-do" ? "selected":"")+'>{{ __('general.to_to') }}</option><option \n\
value="in-progress" '+(task.current_status == "in-progress" ? "selected":"")+'>{{ __('general.in_prog') }}</option><option \n\
value="done" '+(task.current_status == "done" ? "selected":"")+'>{{ __('general.done') }}</option>\n\
</select><button class="btn btn-primary btn-sm  task-row-submit">{{__("general.submit")}}</button></div></div></div>';
 return div;
}


$(document).on('click', '.task-row-submit', function() {
    const taskId = $(this).closest('.task-row').data('id');
    const statusSelect = $('#status-select-' + taskId);
    // const assignSelect = $('#assign-select-' + taskId);

    const statusValue = statusSelect.val();
    // const assignValue = assignSelect.val();

    // Now you can perform AJAX requests to update the status and assign values
    // using the statusValue and assignValue variables

    // Example AJAX request to update status
    _editTask({'id': taskId, 'current_status': statusValue}, this);

    // Example AJAX request to update assign
    // _editTask({'id': taskId, 'assigned_to': assignValue}, this);

    // Also, you can reset the background color of the status select
    statusSelect.css('background', getStatusBgColor(statusValue));
});


function loadTaskDetails(id ,span){
    console.log("Loading : " + id);
    $('#TaskDetailsModal').modal('show');
    $('#exampleModalLabel').html(span.innerHTML);
     $('#modal-heart').html('<div class="text-center p-5"><h4>{{ __('general.loading_data') }}</h4><p>{{ __('general.plz_wait') }}</p></div');
     $.ajax({
              url: '{{url("ops/tasks/fetch-for-emp")}}/' + id,
              type: "GET",
              dataType: 'html',
              success: function (data) {

               $('#modal-heart').html(data);
               _fetchTaskUpdates(id)

              }
});



}


function _loadTaskDetails(id){
    // console.log("Loading : " + id);
    // $('#TaskDetailsModal').modal('show');
    // $('#exampleModalLabel').html(span.innerHTML);
    //  $('#modal-heart').html('<div class="text-center p-5"><h4>{{ __('general.loading_data') }}</h4><p>{{ __('general.plz_wait') }}</p></div');
     $.ajax({
              url: '{{url("ops/tasks/fetch-for-emp")}}/' + id,
              type: "GET",
              dataType: 'html',
              success: function (data) {

               $('#modal-heart').html(data);
               _fetchTaskUpdates(id)

              }
});



}






let start = 1;
function loadMore(){
 start++;
 _fetchTasks();
}
function loadPrev(){
 start--;
 _fetchTasks();
}


function _fetchTasks(title_in){

     $.ajax({
              url: '{{url("ops/tasks/fetchMine")}}?page=' + start,
              type: "POST",
              data: {'title_in' :title_in},
              dataType: 'json',
              success: function (data) {
                if (data.status) {
                       let tasks = "";
                         data = data.data;
                 if(data.data.length == 0){
                     tasks = '<div class="text-center p-5"><h4>{{ __('general.no_data_found') }}</h4><p>{{ __('general.try_again_later') }}</p></div>';
                 }   else{



                 for(var i=0;i<data.data.length;i++){

                    
                    
                tasks += buildTaskCard(data.data[i]);

                $('#download-task-file-'+data.data[i].id).css("display", "none");


                 }
             }
             
                           console.log("page "+data.current_page+" / " + data.last_page)
     tasks+="<div>"; 
           if( parseInt(data.current_page) > 1 )
                     tasks+="<button class='btn btn-sm btn-light mt-2' onclick='loadPrev()'>{{ __('general.load_prev') }}</button>";
     
    if(parseInt(data.last_page) > parseInt(data.current_page) )
                     tasks+="<button class='btn btn-sm btn-light mt-2' onclick='loadMore()'>{{ __('general.load_next') }}</button>";
                 
             
                   tasks+="</div>";  
                   
                   
             
                 document.getElementById('tasks-container').innerHTML = tasks;

                }else{
                    $(".alert").remove();
                    $.each(data.errors, function (key, val) {
                        $("#errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
                    });
                }

              }
});
}



function _editTask(data ,c){
      c.disabled  = true;
     $.ajax({
              url: '{{url("ops/tasks/edit")}}',
              data: data,
              type: "POST",
              dataType: 'json',
              success: function (data) {



                if (data.status) {
              $('#TaskDetailsModal').modal('hide');
            _fetchTasks();


                }else{
                    $(".alert").remove();
                    $.each(data.errors, function (key, val) {
                        $("#errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
                    });
                }

              }
});
}
function getStatusBgColor(status){
    if(status == 'to-do') return  "#f2f2f2";
    if(status == 'in-progress') return  "#b6dfff";
    if(status == 'done') return  "#c5ffc5";
     return  "#f2f2f2";
}
function changeStatusSelectColor(c ,status){
    c.style.background = getStatusBgColor(status)

}





_fetchTasks();


document.getElementById('task-search-button').onclick = function() {
    _searchTask();
};

function _searchTask(){

if($('#task-search').val() == ''){
    alert('Task title cannot be empty!');
    return;
}

document.getElementById('task-search-button').disabled=true;

let title_in = document.getElementById('task-search').value;
   

_fetchTasks(title_in);


document.getElementById('task-search').value="";

document.getElementById('task-search-button').disabled=false;

}



function _hilit(x){
    $('._cxz').removeClass('h');
    for(var i=0;i<=x;i++){
        $('#_cxz' + i).addClass('h');
    }

        let totalMinutes = x;
     var hours = Math.floor(totalMinutes / 60);
    var minutes = totalMinutes % 60;

$('#info').html( hours + " {{ __('general.hours') }} " +parseInt(minutes)+ " {{ __('general.minutes') }}");
      $('#hidden-min-val').html(x);
}
function _hilitC(x){
    let totalMinutes = x;
     var hours = Math.floor(totalMinutes / 60);
    var minutes = totalMinutes % 60;

$('#info-s').html(hours + "{{ __('general.h') }} " +parseInt(minutes)+ "{{ __('general.m') }}");


   $('._cxz').removeClass('hv');
    for(var i=0;i<=x;i++){
        $('#_cxz' + i).addClass('hv');
    }

}
//
function buildTaskUpdateCard(u){
console.log(u);
return "<tr><td>"+u.notes+"</td><td>"+u.created_at_formatted+"</td><td>"+u.duration+"</td><td>"+u.progress+"</td></tr>";
}
function _fetchTaskUpdates(id){
   $("#errors").html("");
     $.ajax({
              url: '{{url("ops/task-updates/fetchAll")}}/' + id,
              type: "GET",
              dataType: 'json',
              success: function (data) {
                if (data.status) {
                       let tasks = "";
                 if(data.data.length == 0){
                     tasks = '<div class="text-center p-5"><h4>{{ __('general.no_data_found') }}</h4><p>{{ __('general.try_again_later') }}</p></div>';
                 }   else{

                    tasks = "<table class='table table-bordered mt-5'><tr><th>{{ __('general.notes') }}</th><th>{{ __('general.date') }}</th><th>{{ __('general.duration') }}</th><th>{{ __('general.progress') }}</th></tr>";

                 for(var i=0;i<data.data.length;i++){
                tasks += buildTaskUpdateCard(data.data[i]);
                 }
                 tasks+="</table>";
             }
                 document.getElementById('task-updates-container').innerHTML = tasks;

                }else{
                    $(".alert").remove();
                    $.each(data.errors, function (key, val) {
                        $("#errors").append("<div class='alert alert-danger'>" + val + "</div>");
                    });
                }

              }
});

}


function resetProgressPicker(){
$('#notes').val("");
$('#info').html("{{ __('general.duration_not_set') }}");
$('#hidden-min-val').html("0");
$('._cxz').removeClass('hv');
$('._cxz').removeClass('h');
}

function _addTaskUpdate(id ,c){
     $("#errors").html("");
     $("#errors").hide();
    if($('#hidden-min-val').html()=="0"){
         $("#errors").html("{{ __('general.empty_time_error') }}");
          $("#errors").show('swing');
            return};
    if($('#notes').val()==""){
         $("#errors").html("{{ __('general.empty_notes_error') }}");
         $('#notes').focus();
             $("#errors").show('swing');
            return};
            c.disabled  = true;
     $.ajax({
              url: '{{url("ops/task-updates/create")}}',
              data: {'task_id' : id ,'notes' : document.getElementById('notes').value ,'duration' :   parseInt($('#hidden-min-val').html())},
              type: "POST",
              dataType: 'json',
              success: function (data) {

                if (data.status) {

              //  $('#TaskDetailsModal').modal('hide');
                  resetProgressPicker()
                //   _fetchTaskUpdates(id);
                  _fetchTasks();

                  c.disabled  = false;
                  _loadTaskDetails(id);
                }else{
                    $(".alert").remove();
                    $.each(data.errors, function (key, val) {
                        $("#errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
                    });
                }

              }
});
}


</script>
@endsection