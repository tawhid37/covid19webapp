@extends('layouts.layout')

@section('content')

    <div class="content">
        <div class="title" style="max-width: 950px;">
            <h1>Final Result</h1>

            <div style="overflow-x: auto;">
                <table class="result-table">
                    <thead>
                        <tr>
                            <th>Your Name</th>
                            <th>Age</th>
                            <th>Sex</th>
                            <th>Temperature</th>
                            <th>Assessment Score</th>
                            <th>COVID-19 Result</th>
                            <th>Advice</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $Name }}</td>
                            <td>{{ $Age }}</td>
                            <td>{{ $Gender }}</td>
                            <td>{{ $Body_temperature }}</td>
                            <td>{{ $total_count }}</td>

                            @if ($total_count == 0)
                                <td style="background-color: #f0fff4; color: #28a745; font-weight: 700; text-align: center;">Negative</td>
                                <td>You are safe. Stay Home Stay Safe</td>

                            @elseif ($total_count < 5)
                                <td style="background-color: #f0fff4; color: #28a745; font-weight: 700; text-align: center;">Negative</td>
                                <td>Merely have chance to get affected by COVID-19. You are adviced for isolation, contact doctor and follow advice.</td>

                            @elseif ($total_count < 7)
                                <td style="background-color: #fff5f5; color: #dc3545; font-weight: 700; text-align: center;">Positive</td>
                                <td>Possible suspected case for COVID-19 affected. You are adviced for isolation, contact doctor and follow advice.</td>

                            @elseif ($total_count < 8)
                                <td style="background-color: #fff5f5; color: #dc3545; font-weight: 700; text-align: center;">Positive</td>
                                <td>Highly chance of COVID-19 affected. You are adviced for isolation and contact doctor immediately and follow advice. A list of emergency phone numbers to contact in case of any emergency:
                                    <br><br>
                                    <strong>16263</strong> - Ministry of Health<br>
                                    <strong>10655</strong> - IEDCR<br>
                                    <strong>333</strong> - National Call Center
                                </td>

                            @else
                                <td style="background-color: #fff5f5; color: #dc3545; font-weight: 700; text-align: center;">Positive</td>
                                <td>Almost confirmed case of COVID 19 positive. You are adviced for isolation and contact doctor immediately and follow advice. You are highly adviced to be hospitalized. A list of emergency phone numbers to contact in case of any emergency:
                                    <br><br>
                                    <strong>16263</strong> - Ministry of Health<br>
                                    <strong>10655</strong> - IEDCR<br>
                                    <strong>333</strong> - National Call Center
                                </td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="result-actions" style="margin-top: 24px;">
                <a href="/assessment">[TEST ANOTHER]</a>
                <a href="/">[BACK TO HOME]</a>
            </div>
        </div>
    </div>

@endsection