@extends('layouts.layout')

@section('content')

    <script type="text/javascript">
    $(document).ready(function () {
        $('#checkBtn').click(function() {
            checked = $("input[type=checkbox]:checked").length;
            if(!checked) {
                alert("You must check at least one checkbox.");
                return false;
            } else {
                $('input[type=checkbox]').removeAttr('required');
            }
        });
    });
    </script>

    <div class="content">
        <div class="title">
            <h1>Self-Assessment Form (Step 3)</h1>

            <div class="user-info-bar">
                <span><strong>Your Name:</strong> {{ $Name }}</span>
                <span><strong>AGE:</strong> {{ $Age }}</span>
                <span><strong>SEX:</strong> {{ $Gender }}</span>
                <span><strong>Body Temperature:</strong> {{ $Body_temperature }}</span>
            </div>

            <form action="/assessment2" method="POST">
                @csrf
                <input type="hidden" id="name" name="name" value="{{ $Name }}">
                <input type="hidden" id="age" name="age" value="{{ $Age }}">
                <input type="hidden" id="sex" name="sex" value="{{ $Gender }}">
                <input type="hidden" id="bodytemp" name="bodytemp" value="{{ $Body_temperature }}">

                @foreach($Symptoms as $s)
                    <input type="hidden" id="symptoms" name="symptoms[]" value="{{ $s }}"> 
                @endforeach

                <fieldset>
                    <label>Additional symptoms?! (Choose multiples if you have many)</label>
                    <div style="margin-top: 12px;">
                        <label class="checkbox-item"><input type="checkbox" name="asymptoms[]" value="abdominal_pain" required> Abdominal pain</label>
                        <label class="checkbox-item"><input type="checkbox" name="asymptoms[]" value="vomiting" required> Vomiting</label>
                        <label class="checkbox-item"><input type="checkbox" name="asymptoms[]" value="chest_pain_or_pressure" required> Chest pain or pressure</label>
                        <label class="checkbox-item"><input type="checkbox" name="asymptoms[]" value="muscle_pain" required> Muscle pain</label>
                        <label class="checkbox-item"><input type="checkbox" name="asymptoms[]" value="loss_of_taste_or_smell" required> Loss of taste or smell</label>
                        <label class="checkbox-item"><input type="checkbox" name="asymptoms[]" value="skin_rash" required> Rash on skin, or discoloration of fingers or toes</label>
                        <label class="checkbox-item"><input type="checkbox" name="asymptoms[]" value="loss_of_speech_or_movement" required> Loss of speech or movement</label>
                        <label class="checkbox-item"><input type="checkbox" name="asymptoms[]" value="NoneofThese" required> None of These</label>
                    </div>
                </fieldset>

                <div style="margin-top: 24px;">
                    <input type="submit" value="Your result" id="checkBtn">
                </div>
            </form>
        </div>
    </div>

@endsection
