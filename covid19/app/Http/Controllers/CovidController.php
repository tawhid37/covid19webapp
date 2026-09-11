<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Covid;
use App\Http\Requests\StoreAssessmentRequest;
use App\Http\Requests\StoreSymptomsRequest;
use App\Http\Requests\StoreAdditionalSymptomsRequest;



class CovidController extends Controller
{

	public function adminpass() {
       
    
        return view('adminpass');
      }

      public function adminenter(Request $req) {

      	if (md5(request('pass'))=="21232f297a57a5a743894a0e4a801fc3"){
      		$req->session()->put('data',md5(request('pass')));

      		$covid = Covid::select("id",'Name', 'Age','SEX', 'Temperature','Score','Result','created_at')->get(); 
        	return view('adminshow', ['covid' => $covid]);

      	}
      	else{
      		return redirect('/adminpass')->with('mssg', 'Password is not Correct');
      	}
        
    
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
       	  $counter=0;
         
          $Body_temperature = $request->input('bodytemp');
		  

		  $design_id = 'NoneofThese';
		  $Symptoms = $request->input('symptoms');

			if(in_array($design_id, $Symptoms) and count($Symptoms)==1)
			{
			  $counter=0;
			  

			}
			else if (count($Symptoms)>=2)
    			{
    				$counter = $counter+(count($Symptoms)+2);


    			}
     		else {
     			$Symptoms = $request->input('symptoms');
     			if (count($Symptoms)== 1 and !in_array($design_id, $Symptoms) ) {
    			$counter = $counter+3;
    			
    			
    		}}

    	  $design_id = 'NoneofThese';
		  $ASymptoms = $request->input('asymptoms');

		  if(in_array($design_id, $ASymptoms) and count($ASymptoms)==1)
			{
			  $counter=$counter+0;


		  if ((float)$Body_temperature>=99.5 and (float)$Body_temperature<=100.9) {
        			$counter = $counter+ 2;
        		}
			  
			  
			}
     	   else {
     			$ASymptoms = $request->input('asymptoms');
    			$counter = $counter+(count($ASymptoms)*2);


		  			if ((float)$Body_temperature>=99.5 and (float)$Body_temperature<=100.9) {
        			$counter = $counter+ 2;
        		}
    		  } 


        $last_info=[
    	  'total_count' => $counter,
    	  'Name' => $request->input('name'),
          'Age' => $request->input('age'),
          'Gender' => $request->input('sex'),
          'Body_temperature' => $request->input('bodytemp')

    	]; 

    	if ($counter < 5){$text="Negative" ;}
        else {$text="Positive" ;}
                                          

    	  $covid = new Covid();
      
          $covid->Name = $request->input('name');
          $covid->Age = $request->input('age');
          $covid->SEX =  $request->input('sex');
          $covid->Temperature =  $request->input('bodytemp');
          $covid->Score = $counter;
          $covid->Result = $text;
          //return request('toppings');
          $covid->save();
    	  
    		//return $last_info;
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
