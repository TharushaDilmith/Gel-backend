{{--template for iterate awarding body array and display as table with styles--}}

<!DOCTYPE html>
<html>
<head>
    <title>awardingBody</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>

</head>
<body>

<h2>Awarding Bodies</h2>


<table>
    <!--create table header-->
    <tr>
        <th>Awarding Body ID</th>
        <th>Awarding Body Name</th>
        <th>Brand</th>
    </tr>
    <!--iterate awarding body array and display as table-->
    @for($i = 0; $i <count($awarding_bodies); $i++)
        <tr>
            <td>{{ $awarding_bodies[$i]['id'] }}</td>
            <td>{{ $awarding_bodies[$i]['awarding_body_name'] }}</td>
            <td>{{ $awarding_bodies[$i]['brand_name'] }}</td>
        </tr>
    @endfor
</table>

