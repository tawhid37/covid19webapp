@extends('layouts.layout')

@section('content')


      <script type="text/javascript">
    $(document).ready(function () {
    $('#checkBtn').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one checkbox.");
        return false;
      }
      else{
        $('input[type=checkbox]').removeAttr('required')
      }
    });
});
</script>



            <div class="content">
                <div class="title m-b-md">
                    <h1>Self-Assessment Form (Step 3)</h1>  <br/>

                       <b><pre> Your Name : {{ $Name }}        AGE: {{ $Age }} </pre>
                          <pre> SEX: {{ $Gender }}                Body Temperature: {{ $Body_temperature }}</pre> </b>
                  
                           <form action="/assessment2" method="POST">
                              @csrf
                                <input type="hidden" id="name" name="name" value="{{ $Name }}">
                                <input type="hidden" id="age" name="age" value="{{ $Age }}">
                                <input type="hidden" id="sex" name="sex" value="{{ $Gender }}">
                                <input type="hidden" id="bodytemp" name="bodytemp" value="{{ $Body_temperature }}">

                                @foreach($Symptoms as $s)
                            
                                    <input type="hidden" id="symptoms" name="symptoms[]" value=" {{$s}}"> 
                                  @endforeach
                                  <br>
                
                        
                                <fieldset>
                               <b> <label >Additional symptoms?! (Choose multiples if you have many)</label></b>
                                <br/>

                                  <input type="checkbox" name="asymptoms[]" value="abdominal_pain" required>Abdominal pain <br/>
                                  <input type="checkbox" name="asymptoms[]" value="vomiting" required>Vomiting<br />
                                  <input type="checkbox" name="asymptoms[]" value="chest_pain_or_pressure" required>Chest pain or pressure<br />
                                  <input type="checkbox" name="asymptoms[]" value="muscle_pain" required> Muscle pain<br />
                                  <input type="checkbox" name="asymptoms[]" value="loss_of_taste_or_smell" required>Loss of taste or smell<br />
                                  <input type="checkbox" name="asymptoms[]" value="skin_rash" required>Rash on skin, or discoloration of fingers or toes<br />
                                  <input type="checkbox" name="asymptoms[]" value="loss_of_speech_or_movement" required>Loss of speech or movement<br />
                                  <input type="checkbox" name="asymptoms[]" value="NoneofThese" required>None of These<br />
                                </fieldset>

                                <input type="submit" value="Your result" id="checkBtn">
                              </form>
                </div>
                        
                    </form>
          
                </div>
            </div>
    
 
       @endsection
