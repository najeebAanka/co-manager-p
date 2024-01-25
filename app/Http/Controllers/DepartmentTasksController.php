<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TodoJob;
use Illuminate\Support\Facades\Auth;
use App\Models\JobUpdate;
use Illuminate\Support\Facades\Storage;
use Exception;

class DepartmentTasksController extends Controller
{
    //
    
    
    
    public function fetchTask(Request $request ,$id){
        
       return view('dashboard-pages.modals.task-details')->with(['data' => TodoJob::find($id)]) ;
        
    }

    public function fetchTaskData(Request $request ,$id){
        
       $task = TodoJob::where('id', $id)->first();

       $task->task_file = $task->buildFile();

       $ext = pathinfo($task->task_file, PATHINFO_EXTENSION);
                            
       if( $ext == 'pdf' || $ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'svg' || $ext == 'webp' || $ext == 'jfif'){
        $task->iframe_link = $task->task_file;
                            
        }
        
        elseif( $ext == 'docx' || $ext == 'doc' || $ext == 'pptx' || $ext == 'ppt' || $ext == 'xlsx' || $ext == 'xls'){
            $task->iframe_link = 'https://view.officeapps.live.com/op/embed.aspx?src='.$task->task_file;
        }
        
        else{
            // $task->iframe_link = url('dist/assets/img/empty.png');
            $task->iframe_link = null;
                                
        }

        
       return response()->json([
        'status' => 200,
        'data' => $task
       ]);
        
    }
    
    public function fetchTaskForEmp(Request $request ,$id){
        
       return view('dashboard-pages.modals.task-details-emp')->with(['data' => TodoJob::find($id) ,'wt' => 480]) ;
        
    }
    
//         public function fetchMyTasks(Request $request){
     
//   $tasks = TodoJob::where('assigned_to' ,Auth::id())
//               ->whereNotNull('duration_required') ->latest()->paginate(15);;
// foreach ($tasks as $t){
 
//      $done =  JobUpdate::where('job_id' ,$t->id)
//                            ->sum('working_duration'); 
    
//   if($t->duration_required > 0)
//     $t->progress_span = " <span class='span-prog'>".number_format($done*100/$t->duration_required ,2)." %</span>";
//     else
//    $t->progress_span = " <span class='span-prog red-span'>".__('general.duration_not_set')."</span>";   

//    $t->task_file = $t->buildFile();
 
 
// }
//       return response()->json([
//                     "status" => true, 
//                     "data" => $tasks
//                 ]);
    
//     }
        public function fetchMyTasks(Request $request){

            $title = $request->input('title_in');

    $tasks = TodoJob::where('assigned_to', Auth::id())
                    ->whereNotNull('duration_required')
                    ->when($title, function ($query) use ($title) {
                        return $query->where('title', 'LIKE', '%' . $title . '%');
                    })
                    ->latest()
                    ->paginate(15);

                    
foreach ($tasks as $t){
 
     $done =  JobUpdate::where('job_id' ,$t->id)
                           ->sum('working_duration'); 
    
  if($t->duration_required > 0)
    $t->progress_span = " <span class='span-prog'>".number_format($done*100/$t->duration_required ,2)." %</span>";
    else
   $t->progress_span = " <span class='span-prog red-span'>".__('general.duration_not_set')."</span>";   

   $t->task_file = $t->buildFile();
 
 
}
      return response()->json([
                    "status" => true, 
                    "data" => $tasks
                ]);
    
    }
        public function fetchTaskUpdates(Request $request ,$id){
     
  $job = TodoJob::find($id);
  $updates =  JobUpdate::where('job_id' ,$id)
                               ->latest()->get();
  setlocale(LC_TIME, app()->getLocale() == "ar" ?  'ar_AE' : 'en_US' );
               foreach ($updates as $u){
                    //    $u->created_at_formatted = \Carbon\Carbon::parse($u->created_at)->format('d/m/Y-h:m');
                       $u->created_at_formatted = date('d/m/Y - h:i:s', strtotime($u->created_at));
                    $u->duration = floor($u->working_duration/60).__('general.h')." ".($u->working_duration%60).__('general.m');
                    $u->progress = number_format(\App\Models\JobUpdate::where('job_id' ,$id)
                            ->where('id' ,'<=' ,$u->id)->sum('working_duration')/  $job ->duration_required * 100.0 ,2)." %";
               }
      return response()->json([
                    "status" => true, 
                    "data" =>  $updates
                ]);
    
    }
    
    
//          public function fetchTasks(Request $request){
       
//           $validator = Validator::make($request->all(), [
//             'dep_id' => 'required'
//         ]);
  
//         if ($validator->fails()){
//             return response()->json([
//                     "status" => false,
//                     "errors" => $validator->errors()
//                 ]);
        
//     }
    
    
//       $tasks = TodoJob::where('department_id' ,$request->dep_id)->latest()->paginate(15);
// foreach ($tasks as $t){
 
//      $done =  JobUpdate::where('job_id' ,$t->id)
//                            ->sum('working_duration'); 
//     if($t->duration_required > 0)
//     $t->progress_span = " <span class='span-prog'>".number_format($done*100/$t->duration_required ,2)." %</span>";
//     else
//    $t->progress_span = " <span class='span-prog red-span'>".__('general.duration_not_set')."</span>"; 

//    if($t->assigned_at == null){
//     $t->assigned_at = '';
//    }
 
 
// }
    
//       return response()->json([
//                     "status" => true, 
//                     "data" =>  $tasks
//                 ]);
    
//     }

public function fetchTasks(Request $request) {
    $validator = Validator::make($request->all(), [
        'dep_id' => 'required',
        'title_in' => 'string' // Add validation for the title_in parameter
    ]);

    if ($validator->fails()) {
        return response()->json([
            "status" => false,
            "errors" => $validator->errors()
        ]);
    }

    $tasksQuery = TodoJob::where('department_id', $request->dep_id);

    if ($request->has('title_in') && $request->title_in) {
        $tasksQuery->where('title', 'like', '%' . $request->title_in . '%');
    }

    $tasks = $tasksQuery->latest()->paginate(15);

    foreach ($tasks as $t) {
        $done = JobUpdate::where('job_id', $t->id)->sum('working_duration');
        
        if ($t->duration_required > 0) {
            $t->progress_span = " <span class='span-prog'>" . number_format($done * 100 / $t->duration_required, 2) . " %</span>";
        } else {
            $t->progress_span = " <span class='span-prog red-span'>" . __('general.duration_not_set') . "</span>";
        }

        if ($t->assigned_at === null) {
            $t->assigned_at = '';
        }
    }

    return response()->json([
        "status" => true,
        "data" => $tasks
    ]);
}

    
    
    public function createTask(Request $request){
       
          $validator = Validator::make($request->all(), [
            'title' => 'required',
            'dep_id' => 'required'
        ]);
  
        if ($validator->fails()){
            return response()->json([
                    "status" => false,
                    "errors" => $validator->errors()
                ]);
        
    }
    $todo = new TodoJob();
    $todo->title = $request->title;
    $todo->created_by = Auth::id();
    $todo->department_id = $request->dep_id;
    $todo->save();
    
      return response()->json([
                    "status" => true, 
                    "data" => $todo->id
                ]);
    
    }
    public function addTaskUpdate(Request $request){
       
          $validator = Validator::make($request->all(), [
            'task_id' => 'required',
            'notes' => 'required',
            'duration' => 'required'
        ]);
  
        if ($validator->fails()){
            return response()->json([
                    "status" => false,
                    "errors" => $validator->errors()
                ]);
        
    }
    $user = Auth::user();
    $task = TodoJob::find($request->task_id);
    if($task->assigned_to == $user->id){
    $update = new \App\Models\JobUpdate();
  $update->job_id = $request->task_id;
  $update->notes = $request->notes;
  $update->working_duration = $request->duration;
  $update->created_by = Auth::id();
    
   $update->save();
   
   if(JobUpdate::where('job_id' ,$request->task_id)->sum('working_duration') >= $task->duration_required){
     $task->current_status = 'done';
     $task->save();
   }
    
      return response()->json([
                    "status" => true, 
                    "data" => $update->id
                ]);
    }else{
       return response()->json([
                    "status" => true, 
                    "data" => ["Access rights error"=>"Not assigned to you"]
                ]);  
    }
    
    }
    
    
        public function editTask(Request $request){
       
          $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
  
        if ($validator->fails()){
            return response()->json([
                    "status" => false,
                    "errors" => $validator->errors()
                ]);
        
    }
    $todo = TodoJob::find($request->id);
    $user = Auth::user();
    //  if($user->can('manage-department-tasks') || $todo->assigned_to == $user->id){
     if($user->can('manage-department-tasks') || $user->can('manage-his-department-tasks') || $todo->assigned_to == $user->id){
    if($request->has('current_status')){
        $todo->current_status = $request->current_status; 
    }
     }
    
    
    // if($user->can('manage-department-tasks')){
    if($user->can('manage-department-tasks') || $user->can('manage-his-department-tasks')){
    if($request->has('assigned_to')){
        $todo->assigned_to = $request->assigned_to; 
        $todo->assigned_at = \Carbon\Carbon::now();
    }
    if($request->has('title')){
        $todo->title = $request->title; 
    }
    
     if($request->has('start_date')){
        $todo->start_date = $request->start_date; 
    }
     if($request->has('end_date')){
        $todo->end_date = $request->end_date; 
    }
     if($request->has('duration_required') && $request->duration_required < 60000){
        $todo->duration_required = $request->duration_required; 
    }
     if($request->has('description')){
        $todo->description = $request->description; 
    }



    if($request->file()) {
         

        $fileName = md5(time()).'.'.$request->task_file->getClientOriginalExtension();
        $path = date('Y')."/".date('m')."/".date('d')."";
        
      try {
          if (!Storage::disk('public')->has('tasks/files/' . date('Y') . "/" . date("m") . "/" . date("d") . "/")) {
              Storage::disk('public')->makeDirectory('tasks/files/' . date('Y') . "/" . date("m") . "/" . date("d") . "/");
          }

          $filePath = $request->file('task_file')->storeAs("public/tasks/files/".$path, $fileName);
          $todo->task_file = $path."/".$fileName;

          
      } catch (Exception $r) {
          return back()->with('error', "Failed to upload file " . $r);
      }

  }





    }
    $todo->save();
    
    return response()->json([
                    "status" => true, 
                ]);
    
    }
    
        public function deleteTask(Request $request){
       
          $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
     $todo = TodoJob::find($request->id);
    $todo->delete();
    
      return response()->json([
                    "status" => true, 
                ]);
    
    }
    
}
