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
                    <h1>Self-Assessment Form (Step 2)</h1>  <br>

                   <b><pre> Your Name : {{ $Name }}        AGE: {{ $Age }} </pre>
                          <pre> SEX: {{ $Gender }}                Body Temperature: {{ $Body_temperature }}</pre> </b>

                          

                     <form action="/assessment1" method="POST">
                              @csrf
                                <input type="hidden" id="name" name="name" value="{{ $Name }}">
                                <input type="hidden" id="age" name="age" value="{{ $Age }}">
                                <input type="hidden" id="sex" name="sex" value="{{ $Gender }}">
                            <input type="hidden" id="bodytemp" name="bodytemp" value="{{ $Body_temperature }}">
                                <fieldset>
                                <b><label >Have any of below symptoms?! (Choose multiples if you have many)</label></b>
                                <br/>

                                  <input type="checkbox" name="symptoms[]" value="breathing_problem" required>Breathing problem <br/>
                                  <input type="checkbox" name="symptoms[]" value="dry_cough" required>Dry cough<br />
                                  <input type="checkbox" name="symptoms[]" value="sore_throat" required>Sore throat<br />
                                  <input type="checkbox" name="symptoms[]" value="weakness" required>Weakness<br />
                                  <input type="checkbox" name="symptoms[]" value="runny_nose" required>Runny nose<br />
                                  <input type="checkbox" name="symptoms[]" value="NoneofThese" required>None of These<br />
                                </fieldset>

                                <input type="submit" id="checkBtn"value="step3">
                              </form>
                </div>
                        
                    </form>
          
                </div>
            </div>

                 @endsection