@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <section id="hero" class="col-md-12">
            <div class="card mt-5-5">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('You are logged in!') }}
                </div>
                <div class="card-body">
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint vel totam dicta corrupti eligendi eos doloribus distinctio fugit soluta vero. Eligendi quas officiis pariatur nostrum temporibus numquam autem hic fugit?
                        Lorem
                    </p>
                    <p>
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis debitis facilis explicabo? Optio praesentium perferendis sed, veniam similique, ea sit deleniti tenetur laudantium aliquam obcaecati. Voluptatibus, quia? Suscipit, atque excepturi. Lorem
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Non doloribus nobis ex unde, iste iusto nam mollitia cupiditate eveniet consectetur? Excepturi nisi ut laboriosam culpa distinctio aut quia officiis obcaecati!
                    </p>
                <!-- /.card-body -->
            </div>
        </section>
        <section id="poktan" class="col-md-12">
            <div class="card mt-5-5">
                <div class="card-header">
                    Data Kelompok Tani
                    {{-- <a class="btn btn-sm btn-primary float-end scrollto" href="#poktanForm" onclick="addClick();"><i class="fa-solid fa-plus"></i> Add</a> --}}
                    <button type="button" class="btn btn-sm btn-primary float-end scrollto" onclick="addClick();"><i class="fa-solid fa-plus"></i> Add</button>
                </div>
                <div class="card-body">
                    <table id="poktanTable" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr class="text-center">
                                <th class="col-md-1">No.</th>
                                <th>Name</th>
                                <th class="col-md-3">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </section>
        <section id="poktanDetail" class="col-md-12 collapse">
            <div class="card mt-5-5">
                <div class="card-header">Detail Kelompok Tani</div>
                <div class="card-body">
                    <div class=" panel panel-primary">
                        <div class="panel-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="poktanname">Name</label>
                                <label class="col-sm-10 col-form-label" id="poktanname"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="poktanForm" class="col-md-12 collapse">
            <div class="card mt-5-5">
                <div class="card-header">Form Kelompok Tani</div>
                <div class="card-body">
                    <div class=" panel panel-primary">
                        <div class="panel-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="poktanname">Name</label>
                                <input type="text" id="poktanname" class="col-sm-8 col-form-label"/>
                                <input type="hidden" id="poktanid" />
                                <button type="button" id="updateButton" class="btn btn-primary col-sm-12 col-form-label" onclick="updateClick();">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
    // Handle default start
    $(document).ready(function () {
        clearForm();
        clearDetail();
        loadPoktanList();
    });
    // Handle click event on Add button
    function addClick() {
        clearDetail();
        clearForm();
        $('#poktanForm').show();
        scrollTo('poktanForm');
    }
    // Handle click event on Update button
    function updateClick() {
        clearDetail();
        // clearForm();
        $('#poktanForm').show();
        scrollTo('poktanForm');

        // Build poktan object from inputs
        Poktan = new Object();
        Poktan.name = $('#poktanForm #poktanname').val();
        Poktan.id = $('#poktanForm #poktanid').val();
        if ($('#poktanForm #updateButton').text().trim() == 'Add') {
            poktanAdd(Poktan);
        }else{
            poktanUpdate(Poktan);
        }
    }
    // Response Form Process Add Button
    function poktanAdd(xhr) {
        $.ajax({
            url: 'http://127.0.0.1:8000/api/kelompok_tani',
            type: 'POST',
            contentType: 'application/json;charset=utf-8',
            data: JSON.stringify(xhr),
            success: function (xhr, message, error) {
                if(xhr.success){
                    clearForm();
                    loadPoktanList();
                    scrollTo('poktan');
                } else {
                    scrollTo('poktanForm');
                    alert('Message : ' + xhr.message.name);
                }
            },
            error: function (xhr, message, error) {
                handleException(xhr, message, error);
            }
        });
    }
    // Response Form Process Update Button
    function poktanUpdate(xhr) {
        $.ajax({
            url: 'http://127.0.0.1:8000/api/kelompok_tani/' + xhr.id,
            type: 'POST',
            contentType: 'application/json;charset=utf-8',
            data: JSON.stringify(xhr),
            success: function (xhr, message) {
                if(xhr.success){
                    clearForm();
                    loadPoktanList();
                    scrollTo('poktan');
                } else {
                    scrollTo('poktanForm');
                    alert('Message : ' + xhr.message.name);
                }
            },
            error: function (xhr, message, error) {
                handleException(xhr, message, error);
            }
        });
    }
    // clearDetail
    function clearDetail() {
        $('#poktanDetail').hide();
        $('#poktanDetail #poktanname').text('');
    }
    // clearForm
    function clearForm() {
        $('#poktanForm').hide();
        $('#poktanForm input').val('');
        $('#poktanForm #updateButton').text('Add');
    }
    // Load Table
    function loadPoktanList() {
        $('#poktanTable > tbody').html('');
        // Call Web API to get a list of poktan
        $('#poktanTable').html
        $.ajax({
            url: 'http://127.0.0.1:8000/api/kelompok_tani',
            type: 'GET',
            dataType: 'json',
            success: function (xhr) {
                $.each(xhr, function (key, value) {
                    // Add a row to the value table
                    if ($('#poktanTable tbody').length == 0) {
                        $('#poktanTable').append('<tbody></tbody>');
                    }
                    // Append row to <table>
                        $('#poktanTable > tbody').append(
                            '<tr>' +
                                '<td class="text-center">' + (parseInt(key)+1) + '</td>' +
                                '<td>' + value.name + '</td>' +
                                '<td class="text-center">' +
                                    '<button type="button" ' +
                                        ' onclick="poktanDet(this);" ' +
                                        ' class="btn btn-sm btn-success" ' +
                                        ' data-id="' + value.id + '">' +
                                        '<i class="fa-solid fa-eye"></i>' +
                                    '</button> ' +
                                    '<button type="button" ' +
                                        ' onclick="poktanGet(this);" ' +
                                        ' class="btn btn-sm btn-warning" ' +
                                        ' data-id="' + value.id + '">' +
                                        '<i class="fa-solid fa-pencil"></i>' +
                                    '</button> ' +
                                    '<button type="button" ' +
                                        ' onclick="poktanDel(this);" ' +
                                        ' class="btn btn-sm btn-danger" ' +
                                        ' data-id="' + value.id + '">' +
                                        '<i class="fa-solid fa-trash"></i>' +
                                    '</button>' +
                                    '</td>' +
                                '</tr>'
                        );
                });
            },
            error: function (xhr, message, error) {
                handleException(xhr, message, error);
            }
        });
    }
    function poktanDet(ctl) {
        clearForm();
        $('#poktanDetail').show();
        // Get poktan id from data- attribute
        var id = $(ctl).data('id');
        // Store poktan id in hidden field
        // $('#poktanid').val(id);
        // Call Web API to get a list of Poktans
        $.ajax({
            url: 'http://127.0.0.1:8000/api/kelompok_tani/' + id,
            type: 'GET',
            dataType: 'json',
            success: function (xhr) {
                $('#poktanDetail #poktanname').text(xhr.name);
                scrollTo('poktanDetail');
            },
            error: function (xhr, message, error) {
                handleException(xhr, message, error);
            }
        });
    }
    function poktanGet(ctl) {
        clearDetail();
        $('#poktanForm').show();
        // Get poktan id from data- attribute
        var id = $(ctl).data('id');
        // Store poktan id in hidden field
        // $('#poktanForm #poktanid').val(id);
        // Call Web API to get a list of Poktans
        $.ajax({
            url: 'http://127.0.0.1:8000/api/kelompok_tani/' + id,
            type: 'GET',
            dataType: 'json',
            success: function (xhr) {
                $('#poktanForm #poktanname').val(xhr.name);
                $('#poktanForm #poktanid').val(xhr.id);
                // Change Update Button Text
                $('#updateButton').text('Update');
                scrollTo('poktanForm');
            },
            error: function (xhr, message, error) {
                handleException(xhr, message, error);
            }
        });
    }
    function poktanDel(ctl) {
        // Get poktan id from data- attribute
        var id = $(ctl).data('id');
        // Call Web API to get a list of Poktans
        $.ajax({
            url: 'http://127.0.0.1:8000/api/kelompok_tani/' + id,
            type: 'DELETE',
            dataType: 'json',
            success: function (poktan) {
                clearDetail();
                clearForm();
                loadPoktanList();
            },
            error: function (xhr, message, error) {
                handleException(xhr, message, error);
            }
        });
    }
    function scrollTo(params) {
        $('html, body').animate({
            scrollTop: ($('#' + params).offset().top)
        }, 50);
    }
    function handleException(xhr, message, error) {
        scrollTo('poktanForm');
        var err = eval("(" + xhr.responseText + ")");
        var msg = 'Message : ' + err.errors.name + '\n';
        alert(msg);
    }
</script>
@endsection
