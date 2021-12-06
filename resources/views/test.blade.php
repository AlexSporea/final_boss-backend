<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table, td, th {
            border: 1px solid black;
        }

        tr:nth-child(even) {
            background-color: lightgray;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <th>id</th>
            <th>nameEs</th>
            <th>nameEu</th>
        </thead>
        <tbody>
            @foreach($eventsArray as $event)
            <tr>
                <td>{{$event['id']}}</td>
                <td>{{$event['nameEs']}}</td>
                <td>{{$event['nameEu']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>