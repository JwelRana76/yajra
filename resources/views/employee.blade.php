<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-5">
                <a href="javascript:void(0)" class="btn btn-primary addEmployee float-end">Add</a>
                <table class="display" id="myTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- add & edit model for employee --}}
    <div class="modal fade" id="employeeModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="employeeModelHeader"></h5>
            </div>
            <div class="modal-body">
              <form id="employeeForm">
                <input type="hidden" name="employee_id" id="employee_id">
                <div class="mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="mb-3">
                    <label for="address">address</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="mb-3">
                    <input type="button" class="btn btn-success" id="saveEmployee" value="Save">
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/jqury.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>

<script>
    
    var table =  $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('employee.index') }}",
            columns: [
                {data: 'name'},
                {data: 'phone'},
                {data: 'address'},
                {data: 'action'},
            ]
    });

    $('.addEmployee').click(function (e) { 
        e.preventDefault();
        $('#employee_id').val('');
        $('#employeeForm').trigger('reset');
        $('#employeeModel').modal('show');
        $('#employeeModelHeader').html('Add Employee');
        
    });

    $('#saveEmployee').click(function (e) { 
        e.preventDefault();
        $(this).html('Save');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            data: $('#employeeForm').serialize(),
            type: "POST",
            url: "{{ route('employee.store') }}",
            dataType: "json",
            success: function (response) {
                $('#employeeForm').trigger('reset');
                $('#employeeModel').modal('hide');
                table.draw();
            },
            error:function(data){
                console.log('Error:',data);
                $('#saveEmployee').html('Save');
            }
        });
    });

    $(document).on('click','.editEmployee', function () {
        var employee_id = $(this).data('id');
        $.get("{{ route('employee.index') }}"+"/"+employee_id+"/edit",
            function (data) {
                $('#employeeModel').modal('show');
                $('#employeeModelHeader').html('Edit Employee');
                $('#employee_id').val(data.data.id);
                $('#name').val(data.data.name);
                $('#phone').val(data.data.phone);
                $('#address').val(data.data.address);
            },
        );
    });
    $.get("url",
        function (data) {
            $.each(data.data, function (i, item) { 
                 $('#district').append('<option>');
            });
        }
    );
</script>
</body>
</html>