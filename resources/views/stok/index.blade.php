@extends('layouts.master')

@section('title')
    Stok Kontol Memek
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Stok Kontol Memek Jaran</li>
@endsection

@section('content')
<div class="modal-body">
    <table class="table table-striped table-bordered table-detail">
        <thead>
            {{-- <th width="5%">No</th> --}}
            <th>Tanggal Transaksi</th>
            {{-- <th>Kategori</th> --}}
            <th>Nama</th>
            <th>Jumlah</th>
            <th>Total</th>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                {{-- <td>{{ $key }}</td> --}}
                <td>{{ $item->created_at }}</td>
                {{-- @if($item->produk)
                @if($item->produk->kategori)
                <td>{{$item->produk}}</td>
                @else
                <td>-</td>
                @endif
                @else
                <td>-</td>
                @endif --}}
                @if($item->produk)
                <td>{{$item->produk->nama_produk}}</td>
                @else
                <td>-</td>
                @endif
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->subtotal }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</div>
</div>
@endsection
