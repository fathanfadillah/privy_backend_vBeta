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
            <div class="col-md-8">
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
                                    <th>Title</th>
                                    <th>Deskripsi</th>
                                    <th>Foto</th>
                                    <!-- <th>Jenis Bayar</th>
                                    <th>Status</th>
                                    <th>Pedagang</th> -->
                                    <th width="60"></th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div id="alert"></div>
                <div class="card no-b">
                    <div class="card-body">
                        <form class="needs-validation" id="form" method="POST" enctype="multipart/form-data" novalidate>
                            {{ method_field('POST') }}
                            <input type="hidden" id="id" name="id" />
                            <h4 id="formTitle">Tambah Data</h4>
                            <hr>
                            <div class="form-row form-inline">
                                <div class="col-md-12">
                                    <div class="form-group m-0">
                                        <label for="title" class="col-form-label s-12 col-md-4">Title</label>
                                        <input type="text" name="title" id="title" placeholder=""
                                            class="form-control r-0 light s-12 col-md-8" autocomplete="off" required />
                                    </div>
                                    <!-- <div class="form-group m-0">
                                        <label for="no_telp" class="col-form-label s-12 col-md-4">No Telp</label>
                                        <input type="text" name="no_telp" id="no_telp" placeholder="" class="form-control r-0 light s-12 col-md-8" autocomplete="off" required/>
                                    </div> -->
                                    <div class="form-group m-0">
                                        <label for="deskripsi" class="col-form-label s-12 col-md-4">Deskripsi</label>
                                        <input type="text" name="deskripsi" id="deskripsi" placeholder=""
                                            class="form-control r-0 light s-12 col-md-8" autocomplete="off" required />
                                    </div>
                                    <div class="form-group m-0">
                                        <label for="" class="col-form-label s-12 col-md-4">Foto</label>
                                        <input type="file" name="foto" id="file" class="input-file"
                                            onchange="tampilkanPreview(this,'preview')">
                                        <label for="file" class="btn-tertiary js-labelFile col-md-8">
                                            <i class="icon icon-image mr-2 m-b-1"></i>
                                            <span id="changeText" class="js-fileName">Browse Image</span>
                                        </label>
                                        <img id="result" class="d-none" width="150">
                                        <img width="150" class="rounded img-fluid m-l-240 mt-1 mb-1" id="preview"
                                            alt="" />

                                    </div>
                                    <!-- <div class="form-group m-0">
                                        <label for="alamat_pedagang" class="col-form-label s-12 col-md-4">Alamat</label>
                                        <textarea name="alamat_pedagang" id="alamat_pedagang" placeholder="" class="form-control r-0 light s-12 col-md-8" autocomplete="off" required></textarea>
                                    </div> -->
                                    <div class="mt-2" style="margin-left: 34%">
                                        <button type="submit" class="btn btn-primary btn-sm" id="action"><i
                                                class="icon-save mr-2"></i>Simpan<span id="txtAction"></span></button>
                                        <a class="btn btn-sm" onclick="add()" id="reset">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </form>
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
            data: 'title',
            name: 'title'
        },
        // {data: 'no_telp', name: 'no_telp'},
        {
            data: 'deskripsi',
            name: 'deskripsi'
        },
        {
            data: 'foto',
            name: 'foto'
        },
        // {data: 'alamat_pedagang', name: 'alamat_pedagang'},
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            className: 'text-center'
        }
    ]
});

(function() {
    'use strict';
    $('.input-file').each(function() {
        var $input = $(this),
            $label = $input.next('.js-labelFile'),
            labelVal = $label.html();

        $input.on('change', function(element) {
            var fileName = '';
            if (element.target.value) fileName = element.target.value.split('\\').pop();
            fileName ? $label.addClass('has-file').find('.js-fileName').html(fileName) : $label
                .removeClass('has-file').html(labelVal);
        });
    });
})();

function tampilkanPreview(gambar, idpreview) {
    $('#result').attr({
        'src': '-',
        'alt': ''
    });
    var gb = gambar.files;
    for (var i = 0; i < gb.length; i++) {
        var gbPreview = gb[i];
        var imageType = /image.*/;
        var preview = document.getElementById(idpreview);
        var reader = new FileReader();
        if (gbPreview.type.match(imageType)) {
            preview.file = gbPreview;
            reader.onload = (function(element) {
                return function(e) {
                    element.src = e.target.result;
                };
            })(preview);
            reader.readAsDataURL(gbPreview);
        } else {
            $.confirm({
                title: '',
                content: 'Tipe file tidak boleh! haruf format gambar (png, jpg)',
                icon: 'icon icon-close',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'red',
                buttons: {
                    ok: {
                        text: "ok!",
                        btnClass: 'btn-primary',
                        keys: ['enter'],
                        action: add()
                    }
                }
            });
        }
    }
}

function add() {
    save_method = "add";
    $('#form').trigger('reset');
    $('#formTitle').html('Tambah Data');
    $('input[name=_method]').val('POST');
    $('#txtAction').html('');
    $('#preview').attr({
        'src': '-',
        'alt': ''
    });
    $('#result').attr({
        'src': '-',
        'alt': ''
    });
    $('#changeText').html('Browse Image');
    $('#reset').show();
    // $('#reset').focus();
}
add();
$('#form').on('submit', function(e) {
    if ($(this)[0].checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
    } else {
        $('#alert').html('');
        url = (save_method == 'add') ? "{{ route($route.'store') }}" : "{{ route($route.'update', ':id') }}"
            .replace(':id', $('#id').val());
        $.ajax({
            url: url,
            type: (save_method == 'add') ? 'POST' : 'POST',
            data: new FormData(($(this)[0])),
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $('#alert').html(
                    "<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " +
                    data.message + "</div>");
                table.api().ajax.reload();
                add();
            },
            error: function(data) {
                err = '';
                respon = data.responseJSON;
                if (respon.errors) {
                    $.each(respon.errors, function(index, value) {
                        err = err + "<li>" + value + "</li>";
                    });
                }
                $('#alert').html(
                    "<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " +
                    respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
            }
        });
        return false;
    }
    $(this).addClass('was-validated');
});

function edit(id) {
    save_method = 'edit';
    var id = id;
    $('#alert').html('');
    $('#form').trigger('reset');
    $('#formTitle').html(
        "Edit Data <a href='#' onclick='add()' class='btn btn-outline-danger btn-xs pull-right ml-2'>Batal</a>");
    $('#txtAction').html(" Perubahan");
    $('#reset').hide();
    $('#result').attr({
        'src': '-',
        'alt': ''
    });
    $('input[name=_method]').val('PATCH');
    $.get("{{ route($route.'edit', ':id') }}".replace(':id', id), function(data) {
        $('#id').val(data.id);
        var path = "{{$path}}" + data.foto;
        $('#result').attr({
            'src': path,
            'class': 'img-fluid mt-2 mb-2',
            'style': 'margin-left: 50%'
        });
        $('#changeText').html('Change Image');
        $('#title').val(data.title);
        $('#deskripsi').val(data.deskripsi);
    }, "JSON").fail(function() {
        reload();
    });

}

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