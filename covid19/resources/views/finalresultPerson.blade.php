@extends('layouts.layout')

@section('content')


            <div class="content">
                <div class="title m-b-md">
                    <h1>Final Result</h1>  <br/>

                              <table style ='border: 1px solid black;'>
                                  <tr>
                                    <th>Your Name</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th>Temperature</th>
                                    <th>Assessment Score</th>
                                    <th>COVID-19 Result</th>
                                    <th>Advice</th>
                                  </tr>
                                  <tr>
                                    <td>{{ $Name }}</td>
                                    <td>{{ $Age }}</td>
                                    <td>{{ $Gender }}</td>
                                    <td>{{ $Body_temperature }}</td>
                                    <td>{{ $total_count }}</td>

                                    @if ($total_count == 0)
                                          <td>Negative</td>
                                          <td>You are safe. Stay Home Stay Safe</td>


                                    @elseif ($total_count < 5)
                                          <td>Negative</td>
                    <td>Merely have chance to get affected by COVID-19.  You are adviced for isolation ,contact doctor and follow advice.</td>

                                    @elseif ($total_count >=5 )
                                          <td>Positive</td>
                    <td>Possible suspected case for COVID-19 affected.You are adviced for isolation ,contact doctor and follow advice.</td>

                                    @elseif ($total_counte >5 and $total_count< 7)
                                          <td>Positive</td>
<td>Highly chance of COVID-19 affected. You are adviced for isolation and contact doctor immediately and follow advice. A list of emergency phone numbers to contact in case of any emergency.

16263 - Ministry of Health
10655 - IEDCR
333- National Call Center
</td>

                                    @elseif ($total_counte >7 )
                                          <td>Positive</td>
<td>Almost confirmed case of COVID 19 positive. You are adviced for isolation and contact doctor immediately
and follow advice.  You are highly adviced to be hospitalized. A list of emergency phone numbers to contact in case of any emergency.

16263 - Ministry of Health
10655 - IEDCR
333- National Call Center</td>

                                    @endif
                                  </tr>
                                </table>
                               <br><br> <a href="/assessment">[TEST ANOTHER]</a>&nbsp&nbsp<a href="/">[BACK TO HOME]</a>
                              </form>
                </div>
                        
                    </form>
          
                </div>
            </div>
    
   @endsection
<style >
          table, th, td {
  border: 1px solid black;
}
</style>