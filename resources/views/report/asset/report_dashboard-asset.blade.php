<!DOCTYPE html>
<html>
<head>
    <title>{{ $title .' - '. date('Y-m-d H:i:s')}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
    <div class="title">{{ $title .' '. \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
    <div class="date">Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
    @if (!empty($parameter))
        <div style="text-align: left; font-size: 12px; margin-bottom: 10px;">
            @foreach ($parameter as $p)
                <div>{{ $p }}</div>
            @endforeach
        </div>
    @endif

        <p style="font-size: 12px">Berikut Merupakan detail item dari asset sebagai berikut : </p>
        <p style="font-size: 10px; font-weight: bold;">Total Item: {{ count($data) }}</p>
    <table class="table-stepper" style="margin-top: 10px">
        <thead>
            <tr>
                <th>No</th>
                <th>Asset Code</th>
                <th>Satgas</th>
                <th>Lokasi</th>
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
            @foreach($data as $item)
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
                <td>{{ $loop->iteration }}</td>
                <td>{{$item->asset_code}}</td>
                <td>{{$item->satgasRelation == null ?'-' :  $item->satgasRelation->type}}</td>
                <td>{{$item->satgasRelation == null ?'-' :  $item->satgasRelation->name}}</td>
                <td>{{$item->no_un}}</td>
                <td>{{$item->categoryRelation == null ?'-' :  $item->categoryRelation->name}}</td>
                <td>{{$item->subCategoryRelation == null ?'-' :  $item->subCategoryRelation->name}}</td>
                <td>{{$item->typeRelation == null ?'-' :  $item->typeRelation->name}}</td>
                <td>{{$item->merkRelation == null ?'-' :  $item->merkRelation->name}}</td>
                <td>{{$item->no_mesin}}</td>
                <td>{{$item->no_rangka}}</td>
                <td>{{$kondisi}}</td>
            </tr>  
        @endforeach
        </tbody>
    </table>
</body>
</html>
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .title {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
    }

    .date {
        text-align: right;
        font-size: 12px;
    }

    .image {
        max-width: 85mm !important;
        min-height: 85mm !important;
        max-height: 85mm !important;
        display: block;
        text-align: left;
    }

    .chart {
        text-align: left;
        margin-top: 10px;
    }

    .table-stepper {
        font-family: 'Poppins', sans-serif;
        border-collapse: collapse;
        width: 100% !important;
        font-size: 9px;
        border: 1px solid #ddd;
    }

    .table-stepper tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .table-stepper tr:hover {
        background-color: #ddd;
    }

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
        font-family: 'Poppins', sans-serif;
        border-collapse: collapse;
        width: 100% !important;
        font-size: 12px;
    }
</style>

