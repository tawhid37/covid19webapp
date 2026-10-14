@extends('layouts.layout')

@section('content')

    <div class="top-nav">
        <a href="/" class="admin-link">BACK TO HOME</a>
    </div>

    <div class="card-container">
        <div class="assessment-card">
            <h1 class="card-title">Self-Assessment Form (Step 1)</h1>

            <form action="/assessment" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Your name:</label>
                    <input type="text" autocomplete="off" name="name" id="name" required>
                </div>

                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" autocomplete="off" name="age" id="age" min="1" max="120" step="1" required>
                </div>

                <div class="form-group">
                    <label for="sex">Gender:</label>
                    <select name="sex" id="sex" required>
                        <option value="" disabled selected></option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div class="form-group temp-group">
                    <label for="ageInputId">Body Temperature (Move the slider to set your value):</label>
                    
                    <div class="slider-header-row">
                        <span class="temp-min">98.1</span>
                        <span class="temp-current" id="tempDisplay">99.8</span>
                        <span class="temp-max">104.0</span>
                    </div>

                    <input type="range" name="ageInputName" id="ageInputId" min="98.1" max="104.0" step="0.1" value="99.8" oninput="updateTemperature(this.value)" required>

                    <div class="temp-box-wrapper">
                        <input name="bodytemp" id="bodytemp" value="99.8" autocomplete="off" required readonly>
                    </div>
                </div>

                <div class="form-actions">
                    <input type="submit" value="Go to next details" class="btn-green">
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateTemperature(val) {
            document.getElementById('bodytemp').value = val;
            document.getElementById('tempDisplay').textContent = val;
        }
    </script>

@endsection