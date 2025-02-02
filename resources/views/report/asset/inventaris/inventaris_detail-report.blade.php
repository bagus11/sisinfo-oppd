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
    @php
        $kondisi = '';
    @endphp
    <div class="container">
        <h1>Laporan Kondisi & Harwat</h1>
        <table style="width: 40%">
            <tr>
                <td>Tanggal</td>
                <td>: {{ $head->created_at->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>No Transaksi</td>
                <td>: {{ $head->inventaris_code }}</td>
            </tr>
            <tr>
                <td>Reporter</td>
                <td>: {{ auth()->user()->name }}</td>
            </tr>
        </table>
        
        <table class="table-stepper" style="width: 50%; font-size:9px; margin-top:10px; table-layout: auto;">
            <thead>
                <tr>
                    @foreach($summary as $head)
                        @php
                            $kondisiHead = '';
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
                        <th style="text-align: center; padding: 8px;">{{$kondisiHead}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($summary as $head)
                        <td style="text-align: center">{{$head->total}}</td> <!-- Assuming 'total' is a field for each condition -->
                    @endforeach
                </tr>  
            </tbody>
        </table>
        
                
        
        <!-- Second Table: Detailed Report -->
        <table class="table-stepper" style="width: 100%; font-size:9px; margin-top:15px">
            <thead>
                <tr>
                    <th>Kondisi</th>
                    <th>Satgas</th>
                    <th>No UN</th>
                    <th>Kategori</th>
                    <th>Sub Kategori</th>
                    <th>Jenis</th>
                    <th>Merk</th>
                    <th>No Mesin</th>
                    <th>No Rangka</th>
                    <th>Catatan</th>
                    <th>Attachment</th>
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
                        <td>{{$kondisi}}</td>
                        <td>{{$item->satgasRelation->name}}</td>
                        <td>{{$item->assetRelation->no_un}}</td>
                        <td>{{$item->assetRelation->categoryRelation->name}}</td>
                        <td>{{$item->assetRelation->subCategoryRelation->name}}</td>
                        <td>{{$item->assetRelation->typeRelation->name}}</td>
                        <td>{{$item->assetRelation->merkRelation->name}}</td>
                        <td>{{$item->assetRelation->noRangka}}</td>
                        <td>{{$item->assetRelation->no_mesin}}</td>
                        <td>{{$item->catatan}}</td>
                        <td>
                            @if($item->attachment !== '')
                                <img style="width:150px" src="{{ public_path('storage/'.$item->attachment) }}" alt="">
                            @else
                                <!-- No attachment logic goes here -->
                            @endif
                        </td>
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
