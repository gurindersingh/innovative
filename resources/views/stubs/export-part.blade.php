<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <meta
        http-equiv="Content-Type"
        content="text/html; charset=utf-8"
    />
    <title>Selected parts</title>

    <style>
        table {
            width: 95%;
            border-collapse: collapse;
            margin: 50px auto;
        }

        /* Zebra striping */
        tr:nth-of-type(odd) {
            background: #eee;
        }

        th {
            background: #3498db;
            color: white;
            font-weight: bold;
        }

        td,
        th {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 18px;
        }
    </style>

</head>

<body>

    <div style="width: 95%; margin: 0 auto;">
        <div style="width: 50%; float: left;">
            <h1>Selected Parts</h1>
        </div>
    </div>

    <table style="position: relative; top: 50px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Number</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parts as $part)
                <tr>
                    <td class="">{{ $part->id }}</td>
                    <td class="">{{ $part->name }}</td>
                    <td class="">{{ $part->number }}</td>
                    <td class="">{{ $part->location }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
