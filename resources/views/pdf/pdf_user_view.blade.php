<html>
<head>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }

        body {
            margin: 3cm 2cm 2cm;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #2a0927;
            color: white;
            text-align: center;
            line-height: 30px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #2a0927;
            color: white;
            text-align: center;
            line-height: 35px;
        }

        table {
            border-collapse: separate;
            border-spacing: 0px 20px;
        }

        table tr th {
            padding: 10px;
            background-color: #d0dbd0;
            border-bottom: 1pt solid #8f6f6f;
        }

        table tr td {
            padding: 10px;
        }

    </style>
</head>
<body>
<header>
    <h1>CRM</h1>
</header>

<main>
    <h1>User list</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
                <tr style="margin-top: 10px">
                    <td>{!! $d->id !!}</td>
                    <td>{!! $d->username !!}</td>
                    <td>{!! $d->firstname !!}</td>
                    <td>{!! $d->lastname !!}</td>
                    <td>{!! $d->email !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</main>

<footer>
    <h1>CRM</h1>
</footer>
</body>
</html>
