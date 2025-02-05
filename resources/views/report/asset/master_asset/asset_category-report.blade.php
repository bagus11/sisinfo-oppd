<!DOCTYPE html>
<html>
<head>
    <title>Laporan PDF</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .title { text-align: center; font-size: 16px; font-weight: bold; }
        .date { text-align: right; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
      
        .chart { text-align: center; margin-top: 20px; }
        .table-stepper {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100% !important;
            font-size: 9px;
            border: 1px solid #ddd;
        }
        .table-stepper tr:nth-child(even) { background-color: #f2f2f2; }
        .table-stepper tr:hover { background-color: #ddd; }
        .table-stepper th {
            border: 1px solid rgb(182, 181, 181);
            padding: 5px;
            text-align: center;
            background-color: #2973B2;
            color: white;
        }
        .table-stepper td {
            padding: 8px;
            border: 1px solid rgb(182, 181, 181);
        }
        .datatable-bordered {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100% !important;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="title">{{ $title }}</div>
    <div class="date">Tanggal: {{ $date }}</div>

    <!-- Chart -->
    <div class="chart">
        <img src="{{ $chartBase64 }}" width="800">
    </div>

    <!-- Data Table -->
    <table class="table-stepper">
        <thead>
            <tr>
                <th>Category</th>
                @foreach ($data[0] as $key => $value) 
                    @if ($key != 'category') <!-- Skip 'category' key -->
                        <th>{{ $key }}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td style="text-align: left">{{ $row['category'] }}</td>
                    @foreach ($row as $key => $value)
                        @if ($key != 'category') <!-- Skip 'category' key -->
                            <td style="text-align: left">{{ $value ?? 0 }}</td> <!-- Display 0 if value is null -->
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
