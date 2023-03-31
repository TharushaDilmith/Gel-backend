{{--template for iterate courses array and display as table with styles--}}

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

<h2>Courses</h2>


<table>
    <!--create table header-->
    <tr>
        <th>Course ID</th>
        <th>Course Name</th>
        <th>Brand</th>
        <th>Awarding Body</th>
        <th>Course Type</th>
        <th>Course Link</th>
        <th>Course Validity</th>
    </tr>
    <!--iterate awarding body array and display as table-->
    @for($i = 0; $i <count($courses); $i++)
        <tr>
            <td>{{ $courses[$i]['id'] }}</td>
            <td>{{ $courses[$i]['course_name'] }}</td>
            <td>{{ $courses[$i]['brand_name'] }}</td>
            <td>{{ $courses[$i]['awarding_body_name'] }}</td>
            <td>{{ $courses[$i]['course_type'] }}</td>
            <td>{{ $courses[$i]['course_link'] }}</td>
            <td>{{ $courses[$i]['valid'] }}</td>
        </tr>
    @endfor
</table>
