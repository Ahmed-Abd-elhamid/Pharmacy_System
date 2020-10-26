{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Admin Panel')

@include('layouts.sidebar')

@section('content')

<div class="container-fluid">
    <h1>User Addresses</h1>


    <a href="{{route('userAddresses.create')}}" class="btn btn-success mb-3">Add Address</a>
    <div class="table-responsive">
    <table id="clients-table" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Client</th>
                <th>National ID</th>
                <th>street</th>
                <th>Building</th>
                <th>Floor</th>
                <th>flat</th>
                <th>Main Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@stop


@section('js')

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="/js/sweetalert2.all.min.js"></script>
<script>
    $(function() {
        $('#clients-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('userAddresses.index') !!}',
            columns: [{
                    data: 'client',
                    name: 'client'
                },
                {
                    data: 'nat',
                    name: 'nat'
                },
                {
                    data: 'street',
                    name: 'street'
                },
                {
                    data: 'building',
                    name: 'building'
                },
                {
                    data: 'floor',
                    name: 'floor'
                },
                {
                    data: 'flat',
                    name: 'flat'
                },
                {
                    data: 'is_main',
                    name: 'is_main',
                    render: function(data) {
                        return data ? 'True' : 'False'
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });
    });

    function deleteAddress(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "post",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": "DELETE"
                    },
                    url: "{{ url('') }}" + "/admin/userAddresses/" + id,
                    success: function(data) {
                        var table = $('#clients-table').dataTable();
                        table.fnDraw(false);
                        Swal.fire(
                            'Deleted!',
                            'Your record has been deleted.',
                            'success'
                        )
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        Swal.fire(
                            'Not Deleted!',
                            'Your record can\'t be deleted',
                            'error'
                        )
                    }
                });
            }
        })
    }
</script>
@stop
