<!DOCTYPE html>
<html>
<head>
    <title>Laporan PDF</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .title { text-align: center; font-size: 16px; font-weight: bold; }
        .date { text-align: right; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
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
</head>
<body>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="title">{{ $title }}</div>
    <div class="date">Tanggal: {{ $date }}</div>

    <!-- Chart -->
    <div class="chart">
        <img class="image" src="{{ $chartBase64 }}">

    </div>

    <!-- Data Table -->
    <table class="table-stepper" style="margin-top: 10px">
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
    {{-- Ganti Baris --}}
    <pagebreak>
        <p style="font-size: 10px">Berikut Merupakan detail item dari asset sebagai berikut : </p>
    <table class="table-stepper" style="margin-top: 10px">
        <thead>
            <tr>
                <th>Asset Code</th>
                <th>Satgas</th>
                {{-- <th>Lokasi</th> --}}
                <th>No UN</th>
                <th>Kategori</th>
                <th>Sub Kategori</th>
                <th>Jenis</th>
                <th>Merk</th>
                <th>No Mesin</th>
                <th>No Rangka</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($child as $item)
            @php
                switch ($item->kondisi) {
                    case 1: $kondisi = "BAIK"; break;
                    case 2: $kondisi = "RR OPS"; break;
                    case 3: $kondisi = "RB"; break;
                    case 4: $kondisi = "RR TDK OPS"; break;
                    case 5: $kondisi = "M"; break;
                    case 6: $kondisi = "D"; break;
                    default: $kondisi = "TIDAK DIKETAHUI";
                }
            @endphp
            <tr>
                <td>{{$item->asset_code}}</td>
                <td>{{$item->satgasRelation == null ?'-' :  $item->satgasRelation->type}}</td>
                {{-- <td>{{$item->satgasRelation == null ?'-' :  $item->satgasRelation->name}}</td> --}}
                <td>{{$item->no_un}}</td>
                <td>{{$item->categoryRelation == null ?'-' :  $item->categoryRelation->name}}</td>
                <td>{{$item->subCategoryRelation == null ?'-' :  $item->subCategoryRelation->name}}</td>
                <td>{{$item->typeRelation == null ?'-' :  $item->typeRelation->name}}</td>
                <td>{{$item->merkRelation == null ?'-' :  $item->merkRelation->name}}</td>
                <td>{{$item->no_mesin}}</td>
                <td>{{$item->noRangka}}</td>
                <td>{{$kondisi}}</td>
            </tr>  
        @endforeach
        </tbody>
    </table>
</body>
</html>
