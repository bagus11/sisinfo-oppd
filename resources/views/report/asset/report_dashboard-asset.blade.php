<!DOCTYPE html>
<html>
<head>
    <title>{{ $title .' - '. date('Y-m-d H:i:s')}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
    <div class="title">Report Asset 10 Mei 2025</div>

    <div class="header-info">
        <div><strong>Kondisi:</strong> BAIK</div>
        <div><strong>Tanggal:</strong> 10 Mei 2025</div>
    </div>
    
    <div class="subtitle"><strong>Total Item:</strong> {{ count($data) }}</div>
    
    <table class="table-stepper">
        <thead>
            <tr>
                <th>No</th>
                <th>Asset Code</th>
                <th>Satuan</th>
                <th>Lokasi</th>
                <th>No UIN</th>
                <th>Kategori</th>
                <th>Sub Kategori</th>
                <th>Jenis</th>
                <th>Merk</th>
                <th>No Mesin</th>
                <th>No Rangka</th>
                <th>Kondisi</th>
                <th>Catatan Terkini</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $item)
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
                <td class="catatan">{{$item->latest_remark}}</td>
            </tr>  
            @endforeach
        </tbody>
    </table>
    
    
</body>
</html>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        font-size: 12px;
    }

    .title {
        text-align: center;
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .subtitle {
        font-size: 10px;
        margin-bottom: 5px;
    }

    table.table-stepper {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .table-stepper th, .table-stepper td {
        border: 1px solid #aaa;
        padding: 6px 8px;
        text-align: left;
        vertical-align: top;
        word-wrap: break-word;
        word-break: break-word;
    }

    .table-stepper th {
        background-color: #2973B2;
        color: white;
        text-align: center;
    }

    .table-stepper tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .table-stepper td.catatan {
        width: 250px;
        max-width: 250px;
        word-wrap: break-word;
    }

    .header-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 10px;
    }

    .footer-note {
        font-size: 8px;
        margin-top: 20px;
        color: #555;
    }
</style>

