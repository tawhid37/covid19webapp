<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Covid;
use App\Http\Requests\StoreAssessmentRequest;
use App\Http\Requests\StoreSymptomsRequest;
use App\Http\Requests\StoreAdditionalSymptomsRequest;



class CovidController extends Controller
{

	public function adminpass() {
       
        if (session()->has('admin_authenticated')) {
            return redirect('/adminshow');
        }

        return view('adminpass');
      }

      public function adminenter(Request $req) {
        $passwordHash = config('covid19.admin_password_hash');

        if (Hash::check($req->input('pass'), $passwordHash)) {
            $req->session()->put('admin_authenticated', true);

            return redirect('/adminshow');
        }

        return redirect('/adminpass')->with('mssg', 'Password is not Correct');
      }

      public function adminshow() {
        $covid = Covid::select("id", 'Name', 'Age', 'SEX', 'Temperature', 'Score', 'Result', 'created_at')
          ->orderByDesc('id')
          ->paginate(10);

        return view('adminshow', ['covid' => $covid]);
      }

      public function exportCsv() {
        $rows = Covid::select("id", 'Name', 'Age', 'SEX', 'Temperature', 'Score', 'Result', 'created_at')
          ->orderByDesc('id')
          ->get();

        $filename = 'covid19-assessments-' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($rows) {
          $handle = fopen('php://output', 'w');

          fputcsv($handle, ['ID', 'Name', 'Age', 'Sex', 'Temperature', 'Score', 'Result', 'Created At']);

          foreach ($rows as $row) {
            fputcsv($handle, [
              $row->id,
              $row->Name,
              $row->Age,
              $row->SEX,
              $row->Temperature,
              $row->Score,
              $row->Result,
              $row->created_at,
            ]);
          }

          fclose($handle);
        }, $filename, [
          'Content-Type' => 'text/csv',
        ]);
      }



     public function assessmentform() {
       
    
        return view('assessmentform');
      }
       public function store1(StoreAssessmentRequest $request) {
        $info =[      
          'Name' => $request->input('name'),
          'Age' => $request->input('age'),
          'Gender' => $request->input('sex'),
          'Body_temperature' => $request->input('bodytemp')
      ];

     // return $info;

      
          return view('assessmentform2', $info);
    
      
      }

      public function store2(StoreSymptomsRequest $request) {
        

      $info2 =[      
          'Name' => $request->input('name'),
          'Age' => $request->input('age'),
          'Gender' => $request->input('sex'),
          'Body_temperature' => $request->input('bodytemp'),
		  'Symptoms' => $request->input('symptoms')
      ];

     //return $info2;

      
          return view('assessmentform3', $info2);
      
      }

public function finalResult(StoreAdditionalSymptomsRequest $request) 
       {
       	  $scoring = app(\App\Services\ScoringService::class);

          $counter = $scoring->score(
              $request->input('symptoms', []),
              $request->input('asymptoms', []),
              $request->input('bodytemp')
          );

          $text = $scoring->resultFor($counter);

          $last_info=[
        	  'total_count' => $counter,
        	  'Name' => $request->input('name'),
              'Age' => $request->input('age'),
              'Gender' => $request->input('sex'),
              'Body_temperature' => $request->input('bodytemp')

        	]; 

          $covid = new Covid();
      
          $covid->Name = $request->input('name');
          $covid->Age = $request->input('age');
          $covid->SEX =  $request->input('sex');
          $covid->Temperature =  $request->input('bodytemp');
          $covid->Score = $counter;
          $covid->Result = $text;
          $covid->save();
    	  
          return view('finalresultPerson', $last_info);

      }
      
        
      
      
    /*
      public function show($id) {
        $pizza = Pizza::findOrFail($id);

        return view('pizzas.show', ['pizza' => $pizza]);
      }

      public function create() {
        // use the $id variable to query the db for a record
        return view('pizzas.create');
      }

     

      public function destroy($id) {
        $pizza = Pizza::findOrFail($id);
    
        $pizza->delete();
    
        return redirect('/pizzas');
    
    }
 */
}
