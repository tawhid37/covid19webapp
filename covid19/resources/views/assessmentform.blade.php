@extends('layouts.layout')

@section('content')

    <div class="right"><a href="/">BACK TO HOME</a></div>

    <div class="content">
        <div class="title">
            <h1>Self-Assessment Form (Step 1)</h1>

            <form action="/assessment" method="POST">
                @csrf
                <label for="name">Your name:</label>
                <input type="text" autocomplete="off" name="name" id="name" required>

                <label for="age">Age:</label>
                <input type="number" autocomplete="off" name="age" id="age" min="1" max="120" step="1" required>

                <label for="sex">Gender:</label>
                <select name="sex" id="sex" required>
                    <option value="" disabled selected></option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>

                <label for="bodytemp">Body Temperature (Move the slider to set your value):</label>
                <div class="slider-row">
                    <span>98.1</span>
                    <input type="range" name="ageInputName" id="ageInputId" min="98.1" max="104.0" step="0.1" value="98.6" oninput="document.getElementById('bodytemp').value = this.value" required>
                    <span>104.0</span>
                </div>
                <input name="bodytemp" id="bodytemp" value="98.6" autocomplete="off" required readonly>

                <div style="margin-top: 24px;">
                    <input type="submit" value="Go to next details">
                </div>
            </form>
        </div>
    </div>

@endsection