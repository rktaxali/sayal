<!doctype html>

<html>

  <head>
    <title>Your Schedule</title>
    <meta charset="utf-8" />
  </head>

  <body>
    Hi {{ $userData->firstname }},

    <p>This is your Weekly schedule for the week starting {{ $userData->start_date }}</p>
   
    <table style="width:600px; border-collapse: collapse; padding:2px;">
        <thead>
            <tr>
            <th style="width:200px;text-align:left;  border: 1px solid black;">Date</th>
            <th style="width:200px;text-align:left;  border: 1px solid black;">Timings</th>
            <th style="width:200px;text-align:left;  border: 1px solid black;">Store</th>
            </tr>
        </thead>

        <tbody>
            @foreach($scheduleData as $schedule)
                <tr>
                    <td style="width:200px;text-align:left;  border: 1px solid black;">{{$schedule->date}}</td>
                    <td style="width:200px;text-align:left;  border: 1px solid black;">{{$schedule->starttime}} -  {{$schedule->endtime}}</td>
                    <td style="width:200px;text-align:left;  border: 1px solid black;">{{$schedule->store_name}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Kindly accept the schedule by clicking this <a href="sayal.ravitaxali.com/userAcceptScheduleEmail/{{$userData->uuid}}">link</a>

    
  </body>

</html>
