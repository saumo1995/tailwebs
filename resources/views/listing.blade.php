<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        section {
            height:100vh;
            width: 100vw;
        }
        div.dataTables_paginate {
            float: left;
            margin: 0;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap4.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
</head>
<body>
    
        <!-- Login 13 - Bootstrap Brain Component -->
    <section class="bg-light py-3 py-md-5">
        <div class="container bg-light">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Marks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($studentData as $row)
                        <tr>
                            <td>{{$row->name}}</td>
                            <td>{{$row->subject}}</td>
                            <td>{{$row->mark}}</td>
                            <td>
                                <a href="javascript:void(0)" onclick="fetchData('<?= base64_encode($row->id)?>')">Edit</a> 
                                || Delete
                            </td>
                        </tr>
                    @endforeach
                </tfoot>
            </table>
            <br>
            <button type="button" class="btn btn-dark btn-lg" data-toggle="modal" data-target="#myModal">ADD</button>
        </div>
    </section>
    
   <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <form id="addForm">
                @csrf
              <div class="form-group">
                <label for="student_name" class="col-form-label">Name:</label>
                <input type="text" class="form-control" name="name" id="student_name">
              </div>
              <div class="form-group">
                <label for="subject" class="col-form-label">Subject:</label>
                <input type="text" class="form-control" name="subject" id="subject">
              </div>
              <div class="form-group">
                <label for="mark" class="col-form-label">Marks:</label>
                <input type="text" class="form-control" name="mark" id="mark">
              </div>
              <input type="hidden" name="student_id" id="student_id">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button>
          </div>
        </div>
      </div>
  </div>
   
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>  
<script>
    $(document).ready( function() {
        $('#example').DataTable({
            "order": []
        });
    })
    
</script>
<script>
    function submitForm() {
        var formData = $('#addForm').serialize(); // Serialize the form data
        $.ajax({
            type: 'POST',
            url: '{{ route("student.add") }}', // Change to your route
            data: formData,
            success: function(response) {
                if(response=='1'){
                    swal("Success!", "Record Inserted Successfully", "success");
                    setTimeout(function () {
                        $('#myModal').modal('toggle');
                        location.reload();
                    }, 1500);
                    
                }
                else{
                    swal("Oops!", "Record Not Inserted", "error");  
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); // Log the error for debugging
                // Handle error, like showing an error message
            }
        });
    }
    function fetchData(id) {
        let csrfToken = '{{csrf_token()}}';
        $.ajax({
            type: 'POST',
            url: '{{ route("student.data") }}', // Change to your route
            data: {'id':id,'_token':csrfToken},
            success: function(response) {
                if(response!=''){
                    let student_data = JSON.parse(response);
                    $('#student_id').val(student_data.id);
                    $('#student_name').val(student_data.name);
                    $('#subject').val(student_data.subject);
                    $('#mark').val(student_data.mark);

                    $('#myModal').modal('toggle');
                    console.log(student_data);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); // Log the error for debugging
                // Handle error, like showing an error message
            }
        });
    }
</script>

</body>
</html>