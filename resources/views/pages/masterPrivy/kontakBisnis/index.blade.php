@extends('layouts.app')
@section('title', '| '.$title.'')
@section('content')
<div class="page has-sidebar-left height-full">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                        <i class="icon icon-dollar mr-2"></i>
                        List {{ $title }}
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card no-b">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <th width="30">No</th>
                                    <!-- <th>Kode</th> -->
                                    <!-- <th>Retribusi</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Jenis Bayar</th>
                                    <th>Status</th>
                                    <th>Pedagang</th> -->
                                    <th>namaDepan</th>
                                    <th>namaBelakang
                                    </th>
                                    <th>email</th>
                                    <th>phone</th>
                                    <th>divisi</th>
                                    <th>jabatan</th>
                                    <th>namaPerusahaan</th>
                                    <th>namaBrand</th>
                                    <th>kategoriIndustri</th>
                                    <th>tipeDokumen</th>
                                    <th>contohDokumen</th>
                                    <th>jumlahDokumen</th>
                                    <th>caraTandaTangan</th>
                                    <th>caraPenggunaan</th>
                                    <th>waktuImplementasi</th>
                                    <th>catatan</th>
                                    <!-- <th>Foto</th> -->
                                    <!-- <th>Jenis Bayar</th>
                                    <th>Status</th>
                                    <th>Pedagang</th> -->
                                    <th width="40"></th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
var table = $('#dataTable').dataTable({
    processing: true,
    serverSide: true,
    pageLength: 15,
    order: [1, 'asc'],
    ajax: {
        url: "{{ route($route.'api') }}",
        method: 'POST'
    },
    columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            align: 'center',
            className: 'text-center'
        },
        {
            data: 'namaDepan',
            name: 'namaDepan'
        },
        {
            data: 'namaBelakang',
            name: 'namaBelakang'
        },
        {
            data: 'email',
            name: 'email'
        },
        {
            data: 'phone',
            name: 'phone'
        },
        {
            data: 'divisi',
            name: 'divisi'
        },
        {
            data: 'jabatan',
            name: 'jabatan'
        },
        {
            data: 'namaPerusahaan',
            name: 'namaPerusahaan'
        },
        {
            data: 'namaBrand',
            name: 'namaBrand'
        },
        {
            data: 'kategoriIndustri',
            name: 'kategoriIndustri'
        },
        {
            data: 'tipeDokumen',
            name: 'tipeDokumen'
        },
        {
            data: 'contohDokumen',
            name: 'contohDokumen'
        },
        {
            data: 'jumlahDokumen',
            name: 'jumlahDokumen'
        },
        {
            data: 'caraTandaTangan',
            name: 'caraTandaTangan'
        },
        {
            data: 'caraPenggunaan',
            name: 'caraPenggunaan'
        },
        {
            data: 'waktuImplementasi',
            name: 'waktuImplementasi'
        },
        {
            data: 'catatan',
            name: 'catatan'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            className: 'text-center'
        }
    ]
});

function remove(id) {
    $.confirm({
        title: '',
        content: 'Apakah Anda yakin akan menghapus data ini ?',
        icon: 'icon icon-question amber-text',
        theme: 'modern',
        closeIcon: true,
        animation: 'scale',
        type: 'red',
        buttons: {
            ok: {
                text: "ok!",
                btnClass: 'btn-primary',
                keys: ['enter'],
                action: function() {
                    $.post("{{ route($route.'destroy', ':id') }}".replace(':id', id), {
                        '_method': 'DELETE'
                    }, function(data) {
                        table.api().ajax.reload();
                        if (id == $('#id').val()) add();
                    }, "JSON").fail(function() {
                        reload();
                    });
                }
            },
            cancel: function() {}
        }
    });
}
</script>
@endsection