<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TodoJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\EvalStandard;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Exception;



class EvaluationsController extends Controller
{
    public function add(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'current_score' => 'required',
            'standard_id' => 'required',
             'eval_to' => 'required',
             'eval_by' => 'required',
             'notes' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()
            ]);
        }



        $evaluationData = $request->input('current_score');
        $standardIds = $request->input('standard_id');
        $eval_to = $request->input('eval_to');
        $eval_by = $request->input('eval_by');
        $notes = $request->input('notes');

        for ($i = 0; $i < count($standardIds); $i++) {
            $standardId = $standardIds[$i];
            $currentScore = $evaluationData[$i];


            $evaluation = new Evaluation();
            $evaluation->standard_id = $standardId;
            $evaluation->current_score = $currentScore;
            $evaluation->eval_to = $eval_to;
            $evaluation->eval_by = $eval_by;
            $evaluation->notes = $notes;
            $evaluation->save();
        }


        $evaluation_results = Evaluation::where('eval_to', $eval_to)->orderBy('id', 'desc')->get()->take(count($standardIds));

        $sum = 0;

        foreach($evaluation_results as $evaluation_result){
            $sum += $evaluation_result->current_score;
        }

        $final_result = number_format(($sum/(count($standardIds)*5))*100, 2);


        return response()->json([
            "status" => true,
            "final_eval" => $final_result.'%',
        ]);    
    }
}
