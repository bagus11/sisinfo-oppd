<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Laporan Kondisi {{$id}}</title>
    <style>
        @font-face {
            font-family: 'Poppins';
            src: url('{{ public_path("fonts/Poppins-Regular.ttf") }}') format('truetype');
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }

        .container {
            width: 100%;
            padding: 10px;
        }

        .row {
            display: flex;
            width: 100%;
            margin-bottom: 5px;
        }

        .col-2 {
            width: 30%;
            font-weight: bold;
        }

        .col-4 {
            width: 70%;
        }
    </style>
</head>
<body>  
    <div class="container">
        <h1>Laporan Detail Master Asset</h1>
        <table style="width: 35%">
            <tr>
                <td>Tanggal</td>
                <td>: {{ date('d F Y') }}</td>
            </tr>
            <tr>
                <td>Reporter</td>
                <td>: {{ auth()->user()->name }}</td>
            </tr>
        </table>
        <br>
        <table style="width: 80%">
         
            <tr>
                <td>Satgas</td>
                <td>: {{ $head->satgasRelation->name }}</td>
                <td>No UN</td>
                <td>: {{ $head->no_un}}</td>
            </tr>
            <tr>
                <td>Category</td>
                <td>: {{ $head->categoryRelation->name }}</td>
                <td>Sub Category</td>
                <td>: {{ $head->subCategoryRelation->name }}</td>
            </tr>
            <tr>
                <td>Type</td>
                <td>: {{ $head->typeRelation->name }}</td>
                <td>Merk</td>
                <td>: {{ $head->merkRelation->name }}</td>
            </tr>
            <tr>
                <td>No Mesin</td>
                <td>: {{ $head->no_mesin }}</td>
                <td>No Rangka</td>
                <td>: {{ $head->no_rangka }}</td>
            </tr>
            <tr>
                <td>Kondisi</td>
                @php
                switch ($head->kondisi) {
                    case 1: $kondisiHead = "BAIK"; break;
                    case 2: $kondisiHead = "RR OPS"; break;
                    case 3: $kondisiHead = "RB"; break;
                    case 4: $kondisiHead = "RR TDK OPS"; break;
                    case 5: $kondisiHead = "M"; break;
                    case 6: $kondisiHead = "D"; break;
                    default: $kondisiHead = "TIDAK DIKETAHUI";
                }
            @endphp
                <td>: {{ $kondisiHead}}</td>
            </tr>
        </table>
         
        <br>
        <p>Berikut Merupakan Log history dari asset <b>{{$head->asset_code}}</b> sebagai berikut : </p>
        <!-- Second Table: Detailed Report -->
        <table class="table-stepper" style="width: 100%; font-size:9px; margin-top:15px">
            <thead>
                <tr>
                    <th>Created At</th>
                    <th>PIC Name</th>
                    <th>Satgas</th>
                    <th>No UN</th>
                    <th>Category</th>
                    <th>Sub category</th>
                    <th>Type</th>
                    <th>Merk</th>
                    <th>No Mesin</th>
                    <th>No Rangka</th>
                    <th>Kondisi</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>
                @if($child && $child->count())
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
                        <td>{{$item->created_at->format('d F Y')}}</td>
                        <td>{{$item->picRelation->name}}</td>
                        <td>{{$item->satgasRelation->name}}</td>
                        <td>{{$item->no_un}}</td>
                        <td>{{$item->categoryRelation->name}}</td>
                        <td>{{$item->subCategoryRelation->name}}</td>
                        <td>{{$item->typeRelation->name}}</td>
                        <td>{{$item->merkRelation->name}}</td>
                        <td>{{$item->no_mesin}}</td>
                        <td>{{$item->no_rangka}}</td>
                        <td>{{$kondisi}}</td>
                        <td>{{$item->remark}}</td>
                    </tr>  
                @endforeach
            @else
                <p>No data available for child records</p>
            @endif
            
            </tbody>
        </table>
    </div>
</body>
</html>

<style>
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
    }
    .datatable-bordered {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100% !important;
        font-size: 12px;
    }
</style>
