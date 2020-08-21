<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Covid ;



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

       public function store1() {
        $info =[      
          'Name' => request('name'),
          'Age' => request('age'),
          'Gender' => request('sex'),
          'Body_temperature' => request("bodytemp")
      ];

     // return $info;

      
          return view('assessmentform2', $info);
    
      
      }

      public function store2() {
        

      $info2 =[      
          'Name' => request('name'),
          'Age' => request('age'),
          'Gender' => request('sex'),
          'Body_temperature' => request("bodytemp"),
		  'Symptoms'=>request("symptoms")
      ];

     //return $info2;

      
          return view('assessmentform3', $info2);
      
      }

       public function finalResult() 
       {
       	  $counter=0;
         
          $Body_temperature = request("bodytemp");
		  


		  $design_id = 'NoneofThese';
		  $Symptoms= request('symptoms');

			if(in_array($design_id, $Symptoms) and count($Symptoms)==1)
			{
			  $counter=0;
			  

			}
			else if (count($Symptoms)>=2)
    			{
    				$counter = $counter+(count($Symptoms)+2);


    			}
     		else {
     			$Symptoms = request('symptoms');
     			if (count($Symptoms)== 1 and !in_array($design_id, $Symptoms) ) {
    			$counter = $counter+3;
    			
    			
    		}}

    	  $design_id = 'NoneofThese';
		  $ASymptoms= request('asymptoms');

		  if(in_array($design_id, $ASymptoms) and count($ASymptoms)==1)
			{
			  $counter=$counter+0;


		  if ((float)$Body_temperature>=99.5 and (float)$Body_temperature<=100.9) {
        			$counter = $counter+ 2;
        		}
			  
			  
			}
     	   else {
     			$ASymptoms = request('asymptoms');
    			$counter = $counter+(count($ASymptoms)*2);


		  			if ((float)$Body_temperature>=99.5 and (float)$Body_temperature<=100.9) {
        			$counter = $counter+ 2;
        		}
    		  } 


        $last_info=[
    	  'total_count' => $counter,
    	  'Name' => request('name'),
          'Age' => request('age'),
          'Gender' => request('sex'),
          'Body_temperature' => request("bodytemp")

    	]; 

    	if ($counter < 5){$text="Negative" ;}
        else {$text="Positive" ;}
                                          

    	  $covid = new Covid();
      
          $covid->Name = request('name');
          $covid->Age = request('age');
          $covid->SEX =  request('sex');
          $covid->Temperature =  request('bodytemp');
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
