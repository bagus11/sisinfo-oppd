<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>
<body>
    <div class="title">{{ $title }}</div>
    <div class="date">Tanggal: {{ $date }}</div>

    <!-- Insert the base64 chart image here -->
    <div class="chart">
        <img class="image" src="{{ $chartBase64 }}">

    </div>

    <!-- Tabel Data -->
    <table class="table-stepper">
        <thead>
            <tr>
                <th>Kondisi</th>
                @foreach($data[0] as $satgas => $value)
                    @if($satgas != 'category')
                        <th>{{ $satgas }}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    <td>{{ $row['category'] }}</td>
                    @foreach($row as $satgas => $value)
                        @if($satgas != 'category')
                            <td>{{ $value }}</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
<style>
     .title { text-align: center; font-size: 16px; font-weight: bold; }
     .date { text-align: right; font-size: 12px; }
     .image {
            max-width: 85mm !important;
            min-height: 85mm !important;
            max-height: 85mm !important;
            display: block;
            text-align: left; /* Pastikan teks di kiri */
        }
        .chart { text-align: left; margin-top: 10px; }
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
