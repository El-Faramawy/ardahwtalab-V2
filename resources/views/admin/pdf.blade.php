<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@700&display=swap" rel="stylesheet">
     <style type="text/css">
        body
        {
            font-family: 'Cairo', sans-serif;
            font-size: 10pt;
            direction: rtl;
        }
        table
        {
            border: 1px solid #ccc;
            border-collapse: collapse;
        }
        table th
        {
            background-color: #F7F7F7;
            color: #333;
            font-weight: bold;
        }
        table th, table td
        {
            padding: 5px;
            border: 1px solid #ccc;
        }
        @media print {
  @page { margin: 0; }
  body { margin: 1.6cm; }
}
    </style>
</head>
<body>
     <table id="tblCustomers" cellspacing="0" cellpadding="0">
        <tr>
            <th>#</th>
            <th>المعلومات</th>
        </tr>
        @foreach($data as $key=>$value)
        <tr>
            <td style="width: 300px;">{{ $key }}</td>
            <td>
                @if($key == 'تفاصيل')
                    <?php
                        $dd = explode(',',$value);
                    ?>
                    <ul>
                        @foreach($dd as $k=>$v)
                            <li>
                                {{ $v }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    {!! $value !!}
                @endif
            </td>
        </tr>
        @endforeach
    </table>
    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>