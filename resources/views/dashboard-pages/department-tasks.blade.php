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
                                  <input type="text" class="form-control" id="task-input" placeholder="{{ __('general.start_task_here_placeholder') }}" />
                                </div>
                                <div class="col-md-1">
                                  <button class="btn btn-info" id="task-input-button" style="margin-left: 2px;"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>

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

<!-- Modal -->
<div class="modal fade" id="TaskFileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleFileModalLabel"></h5>
        
        </div>
        <div class="modal-body">
         <div class="row">
  
                          
             <div class="col-md-12" id="file-modal-heart">
                            
                        {{-- <div class="text-center p-5"><h4>{{ __('general.loading_data') }}</h4><p>{{ __('general.plz_wait') }}</p></div>
                              
                              
                        </div>    --}}
                        <div class="form-row">

                        <div class="col-md-12 mb-3">
                            <label for="validationDefault02">
                                <h6>{{ __('general.task_file') }}</h6>
                            </label>
                        </div>
                        <div class="col-md-12 mb-3">
                            <input type="hidden" id="task_id_file" class="form-control mb-2">
                            <input type="file" id="task_file" class="form-control mb-2">
                        </div>
                    
                    </div>
                    <button class="btn btn-primary" type="button"
                        onclick="_saveTaskFile(document.getElementById('task_id_file').value ,this)">{{ __('general.upload_file') }}</button>


                        <div id="file_download_div" class="form-group mt-3">
                               
                            
                        </div>

                        <div id="file_preview_div" style="display: none;" class="form-group mt-3">
                                                        
                            <iframe id="file_preview"
                            
                            height="500px" width="100%" style="border: none;"></iframe>
                            
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
let tasks_counter = 0;
function _addTask(){

    if($('#task-input').val() == ''){
        alert('Task title cannot be empty!');
        return;
    }

    document.getElementById('task-input-button').disabled=true;

     tasks_counter++;
    let title_in = document.getElementById('task-input').value;
  let div = '<div class="task-row" id="temptsk'+tasks_counter+'"><div class="row"><div class="col-1 text-center"><i class="fa fa-tasks  status-to-do-i"></i></div>\n\
<div class="col-6">\n\
<p title="'+title_in+'" class="task-text">'+title_in+'</p></div><div class="col-5 align-end"><select class="task-row-select" disabled id="temptskStatus'+tasks_counter+'"><option \n\
value="to-do">{{ __('general.to_to') }}</option>\n\
</select><select class="task-row-select"  disabled id="temptskSAssign'+tasks_counter+'">\n\
<option value="-1">{{ __('general.not_assigned') }}</option></select></div></div></div>';  
    
    document.getElementById('tasks-container').innerHTML=(div)+ document.getElementById('tasks-container').innerHTML;
    document.getElementById('task-input').value="";
   
    
    $.ajax({
              url: '{{url("ops/tasks/create")}}',
              data: {'title' : title_in ,'dep_id'  : {{Route::input('id')}} },
              type: "POST",
              dataType: 'json',
              success: function (data) {
  
                document.getElementById('task-input-button').disabled=false;
  
                if (data.status) {
               

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



function changeStatus(id ,c){
  _editTask({'id' : id ,'current_status' : c.value} ,c);
}
function changeAssign(id ,c){
  _editTask({'id' : id ,'assigned_to' : c.value} ,c);  
}

function buildEditTaskDiv(task){
    return '<div id="input-title-'+task.id+'" class="edit-task-in" style="display : none">\n\
<input  id="input-title-'+task.id+'-text" type="text" class="form-control mb-2"  value="'+task.title+'" \n\
 /><button onclick="saveTaskTitle(this ,'+task.id+')" class="btn btn-default btn-sm m-1"><i class="fa fa-check"></i></button>\n\
<button class="btn btn-default  btn-sm m-1" onclick="hideEditTitleForTask('+task.id+')"><i class="fa fa-times "></i></button>\n\
<button class="btn btn-danger  btn-sm m-1" onclick="deleteTask('+task.id+' ,this)"><i class="fa fa-trash "></i> {{ __('general.delete_task') }}</button></div>';
}
function buildTaskCard(task){
    let div = '<div class="task-row" data-id="'+task.id+'"><div class="row"><div class="col-1 text-center"><i class="fa  fa-stream status-'+task.current_status+'-i"></i></div>\n\
<div class="col-5">\n\
<p title="'+task.title+'" class="task-text" onhover="showEditControls(this , '+task.id+')" id="p-'+task.id+'">\n\
<span onclick="loadTaskDetails('+task.id+' ,this)" class="task-status-'+task.current_status+' spannable-link">'+
    task.title+'</span> '+task.progress_span+' <span class="span-file"><i class="fa fa-link edit-task-file" id="edit-task-file-'+task.id+'" onclick="showEditFileForTask('+task.id+')"></i></span><i class="fa fa-pencil edit-task-title" style="display : none" id="edit-task-title-'+task.id+'" onclick="showEditTitleForTask('+task.id+')"></i></p>\n\
'+buildEditTaskDiv(task)+'</div><div class="col-2" style="text-align: center;">'+task.assigned_at+'</div><div class="col-4 align-end">\n\
<select id="status-select-'+task.id+'" class="task-row-select" style="background : '+getStatusBgColor(task.current_status)+'">\n\
<option value="to-do" '+(task.current_status == "to-do" ? "selected":"")+'>{{ __('general.to_to') }}</option><option \n\
value="in-progress" '+(task.current_status == "in-progress" ? "selected":"")+'>{{ __('general.in_prog') }}</option><option \n\
value="done" '+(task.current_status == "done" ? "selected":"")+'>{{ __('general.done') }}</option>\n\
</select><select id="assign-select-'+task.id+'" class="task-row-select">\n\
<option value="-1">{{ __('general.not_assigned') }}</option>';
 <?php foreach ($users as $u){ ?>
     
  div += '<option '+(task.assigned_to == <?=$u->id?> ? "selected":"")+' value="<?=$u->id?>"><?=$u->name?></option>';   
 <?php } ?>    


 div+=   '</select><button class="btn btn-primary btn-sm task-row-submit">{{__("general.submit")}}</button></div></div></div>';  
 return div;
}


//---------------------------------------stoooooooop heeeeeereeeeeee



$(document).on('click', '.task-row-submit', function() {
    const taskId = $(this).closest('.task-row').data('id');
    const statusSelect = $('#status-select-' + taskId);
    const assignSelect = $('#assign-select-' + taskId);

    const statusValue = statusSelect.val();
    const assignValue = assignSelect.val();

    // Now you can perform AJAX requests to update the status and assign values
    // using the statusValue and assignValue variables

    // Example AJAX request to update status
    _editTask({'id': taskId, 'current_status': statusValue, 'assigned_to': assignValue}, this);

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
              url: '{{url("ops/tasks/fetch")}}/' + id,
              type: "GET",
              dataType: 'html',
              success: function (data) {
              
               $('#modal-heart').html(data);
               
              } 
});
    
    
    
}
function saveTaskTitle(c ,id){
  _editTask({'id' : id ,'title' : document.getElementById('input-title-'+id+'-text').value} ,c);  
}

function resetEditInputs(){
    $('.edit-task-in').hide(); 
$('.task-text').show();  
}

function showEditTitleForTask(id){
    
resetEditInputs();

document.getElementById('p-' + id).style.display = 'none';   
document.getElementById('input-title-' + id).style.display = 'block';    
    
}

function showEditFileForTask(id){
    
// resetEditInputs();

// document.getElementById('p-' + id).style.display = 'none';   
// document.getElementById('input-title-' + id).style.display = 'block'; 



$('#TaskFileModal').modal('show');
$('#task_id_file').val(id);
console.log($('#task_id_file').val());

$.ajax({
              url: '{{url("ops/tasks/fetchTask")}}/' + id,
              type: "GET",
              dataType: 'json',
              success: function (response) {
              
            //    $('#modal-heart').html(data);
            
            $('#exampleFileModalLabel').html(response.data.title);
            // $('#file_preview').attr('src', response.data.iframe_link);

            if(response.data.iframe_link == null){
                $('#file_preview').attr('src', '');
                $('#file_preview_div').css("display", "none");
            }
            else{
                $('#file_preview').attr('src', response.data.iframe_link);
                $('#file_preview_div').css("display", "block");
            }

            if(response.data.task_file == null){
                // $('#file_download_div').css("display", "none");
                $('#file_download_div').html('{{__('general.no_file')}}');
            }
            else{
                // $('#file_download_div').css("display", "block");
                $('#file_download_div').html('<a target="_blank" href="'+response.data.task_file+'">*{{ __('general.download_file') }}*</a>');
            }
               
              } });
              

}

function hideEditTitleForTask(id){

      
document.getElementById('p-' + id).style.display = 'block';    
document.getElementById('input-title-' + id).style.display = 'none';    
    
}

function updateBindings(){
   console.log("updating ..") 
 $(".task-row").hover(function(){
let id = $(this).attr('data-id');

$('#edit-task-title-' + id).show();

}, function(){
let id = $(this).attr('data-id');
$('#edit-task-title-' + id).hide();
})   
    
    
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
              url: '{{url("ops/tasks/fetchAll")}}?page='+start,
              data: {'title_in' :title_in, 'dep_id'  : {{Route::input('id')}} },
              type: "POST",
              dataType: 'json',
              success: function (data) {
                if (data.status) {
                 let tasks = "";
             
                      data = data.data;
                      console.log(data.data);
                 if(data.data.length == 0){
                     tasks = '<div class="text-center p-5"><h4>{{ __('general.no_data_found') }}</h4><p>{{ __('general.try_again_later') }}</p></div>';
                 }   else{

             
                 for(var i=0;i<data.data.length;i++){
                tasks += buildTaskCard(data.data[i]);     
                 }
                 console.log("page "+data.current_page+" / " + data.last_page)
     tasks+="<div>";    
         if( parseInt(data.current_page) > 1 )
                     tasks+="<button class='btn btn-sm btn-light mt-2' onclick='loadPrev()'>{{ __('general.load_prev') }}</button>";
    if(parseInt(data.last_page) > parseInt(data.current_page) )
                     tasks+="<button class='btn btn-sm btn-light mt-2' onclick='loadMore()'>{{ __('general.load_next') }}</button>";
                 
               
                   tasks+="</div>";  
                    } 
                   
                 document.getElementById('tasks-container').innerHTML = tasks;
                 updateBindings();
           
                }else{
                    $(".alert").remove();
                    $.each(data.errors, function (key, val) {
                        $("#errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
                    });
                }
               
              } 
});
}


function deleteTask(id ,c){
          c.disabled  = true;


if(confirm('Are you sure to delete this task?')){
     $.ajax({
              url: '{{url("ops/tasks/delete")}}',
              data: {'id' : id},
              type: "POST",
              dataType: 'json',
              success: function (data) {
                  
                if (data.status) {
             
            _fetchTasks();
                  
                }else{
                    $(".alert").remove();
                    $.each(data.errors, function (key, val) {
                        $("#errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
                    });
                }
               
              } 
});
}else{
    c.disabled  = false;
}
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


function _editTaskFile(data, c) {
    c.disabled = true;

    var formData = new FormData();  // Create a FormData object

    // Append the file input to the FormData object
    var fileInput = document.getElementById('task_file');
    var id = document.getElementById('task_id_file').value;
    console.log('here' +id)
    formData.append('task_file', fileInput.files[0]); // Assuming the file input has ID 'task_file_input'
    formData.append('id', id); // Assuming the file input has ID 'task_file_input'

    // Perform the AJAX request with FormData
    $.ajax({
        url: '{{url("ops/tasks/edit")}}',
        data: formData,  // Use the FormData object here
        type: "POST",
        dataType: 'json',
        contentType: false,  // Set to false for FormData
        processData: false,  // Set to false for FormData
        success: function (data) {
            if (data.status) {
                $('#TaskFileModal').modal('hide');
                $('#task_file').val('');
                $('#file_preview').attr('src', '');
                _fetchTasks();
            } else {
                $(".alert").remove();
                $.each(data.errors, function (key, val) {
                    $("#errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
                });
            }
        },
        complete: function () {
            c.disabled = false;
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

function _saveTaskTiming (id ,c){
     _editTask({'id' : id , 'description' : document.getElementById('task_description').value ,'duration_required' : parseInt(document.getElementById('duration_required_h').value)*60 +
             parseInt(document.getElementById('duration_required_m').value)} ,c);   
    
}

function _saveTaskFile (id ,c){
     
    var formData = new FormData();  // Create a FormData object

    // Append form fields to the FormData object
    formData.append('id', id);
    
    // Append the file input to the FormData object
    var fileInput = document.getElementById('task_file');
    formData.append('task_file', fileInput.files[0]); // Assuming the file input has ID 'task_file'

    // Perform the AJAX request with FormData
    _editTaskFile(formData, c);
}

    

// document.getElementById('task-input').onkeyup = function(event) {
//     if (event.keyCode === 13) {
//         _addTask()
//     }
document.getElementById('task-input-button').onclick = function() {
    _addTask();
};

document.getElementById('task-search-button').onclick = function() {
    _searchTask();
};



_fetchTasks();


//$(window).click(function() {
// resetEditInputs();
//});

</script>
@endsection