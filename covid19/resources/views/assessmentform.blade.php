@extends('layouts.layout')

@section('content')

            <div class="content">
                <div class="title m-b-md">
                    <div class="right"><a href="/">BACK TO HOME</a></div>
                    <h1>Self-Assessment Form(Step 1) </h1>  <br>
                        

                     <form action="/assessment" method="POST">
                              @csrf
                               <b><label for="name">Your name:</label></b>   <input type="text" autocomplete="off" name="name" id="name" required> <br>

                                <b><label for="age">Age       :</label></b><input type="number" autocomplete="off" name="age" id="age" min="1" max="120" Step = 1 required> <br>

                               <b><label for="sex">Gender     :</label></b>
                                    <select name="sex" id="sex" required>
                                      <option value=""></option>
                                      <option value="male">Male</option>
                                      <option value="female">Female</option>
                                    </select> <br><br>
                                <b><label for="bodytemp">Body Temperature:(Move The Blue dot to find the temperature value on text)</label> </b><br>
                                    <b>98.1</b><input type="range" name="ageInputName" id="ageInputId"  min="98.1" max="104.0" Step = 0.1 oninput="bodytemp.value = ageInputId.value" required><b>104.0</b><br>
                                    <input name="bodytemp" id="bodytemp" autocomplete="off" required readonly></input><br>

                                    <input type="submit" value="Go to next details"> 
                              </form>
                </div>
                        
                    </form>

                    
                </div>
            </div>

       @endsection