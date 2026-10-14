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
            <h1>Self-Assessment Form (Step 2)</h1>

            <div class="user-info-bar">
                <span><strong>Your Name:</strong> {{ $Name }}</span>
                <span><strong>AGE:</strong> {{ $Age }}</span>
                <span><strong>SEX:</strong> {{ $Gender }}</span>
                <span><strong>Body Temperature:</strong> {{ $Body_temperature }}</span>
            </div>

            <form action="/assessment1" method="POST">
                @csrf
                <input type="hidden" id="name" name="name" value="{{ $Name }}">
                <input type="hidden" id="age" name="age" value="{{ $Age }}">
                <input type="hidden" id="sex" name="sex" value="{{ $Gender }}">
                <input type="hidden" id="bodytemp" name="bodytemp" value="{{ $Body_temperature }}">

                <fieldset>
                    <label>Have any of below symptoms?! (Choose multiples if you have many)</label>
                    <div style="margin-top: 12px;">
                        <label class="checkbox-item"><input type="checkbox" name="symptoms[]" value="breathing_problem" required> Breathing problem</label>
                        <label class="checkbox-item"><input type="checkbox" name="symptoms[]" value="dry_cough" required> Dry cough</label>
                        <label class="checkbox-item"><input type="checkbox" name="symptoms[]" value="sore_throat" required> Sore throat</label>
                        <label class="checkbox-item"><input type="checkbox" name="symptoms[]" value="weakness" required> Weakness</label>
                        <label class="checkbox-item"><input type="checkbox" name="symptoms[]" value="runny_nose" required> Runny nose</label>
                        <label class="checkbox-item"><input type="checkbox" name="symptoms[]" value="NoneofThese" required> None of These</label>
                    </div>
                </fieldset>

                <div style="margin-top: 24px;">
                    <input type="submit" id="checkBtn" value="step3">
                </div>
            </form>
        </div>
    </div>

@endsection