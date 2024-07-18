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
        .error_span{
            color:red;
        }
        .topnav-right {
        float: right;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
</head>
<body>       
    <section class="bg-light py-3 py-md-5">
        <div class="container bg-light">
            <div class="topnav-right">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("logout") }}"><button type="button" class="btn btn-primary">Logout</button></a>
                    </li>            
                </ul>
          </div> 
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Marks</th>
                        <th class="no-sort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($studentData as $row)
                        <tr>
                            <td>{{$row->name}}</td>
                            <td>{{$row->subject}}</td>
                            <td>{{$row->mark}}</td>
                            <td>
                                <div class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="arrow down"></i>Click
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="fetchData('<?= base64_encode($row->id)?>')">Edit</a> 
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteStudent('<?= base64_encode($row->id)?>')">Delete</a> 
                                    </div>
                                  </div>
                                {{-- <a href="javascript:void(0)" onclick="fetchData('<?= base64_encode($row->id)?>')">Edit</a> 
                                || <a href="javascript:void(0)" onclick="deleteStudent('<?= base64_encode($row->id)?>')">Delete</a>  --}}
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <button type="button" id="addBtn" class="btn btn-dark btn-lg" data-toggle="modal" data-target="#myModal">ADD</button>
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
                <span class="error_span" id="name_span">Required</span>
              </div>
              <div class="form-group">
                <label for="subject" class="col-form-label">Subject:</label>
                <input type="text" class="form-control" name="subject" id="subject">
                <span class="error_span" id="subject_span">Required</span>
              </div>
              <div class="form-group">
                <label for="mark" class="col-form-label">Marks:</label>
                <input type="text" class="form-control" name="mark" id="mark" onkeypress="return /[0-9]/i.test(event.key)" minlength="1" maxlength="3">
                <span class="error_span" id="mark_span">Required</span>
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
        $('.error_span').hide();
        $('#example').DataTable({
            "order": [],
            'columnDefs': [ {
            'targets': [3], /* column index */
            'orderable': false, /* true or false */
              }]
        });
        $("#addBtn").click(function(){
            $('.error_span').hide();
            $('#myModal').find('input:text').val(''); 
            $('#student_id').val('');
        });
    })    
</script>
<script>
    function submitForm() {
        let student_name = $('#student_name').val();
        let subject = $('#subject').val();
        let mark = $('#mark').val();
        let checkFlag = 0;
        if(student_name==''){
            checkFlag = 1;
            $('#name_span').show();
        }
        else{
            $('#name_span').hide();
        }
        if(subject==''){
            checkFlag = 1;
            $('#subject_span').show();
        }
        else{
            $('#subject_span').hide();
        }
        if(mark==''){
            checkFlag = 1;
            $('#mark_span').show();
        }
        else{
            $('#mark_span').hide();
        }
        if(checkFlag==1){
            return false;
        }
        let formData = $('#addForm').serialize();
        $.ajax({
            type: 'POST',
            url: '{{ route("student.add") }}', 
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
                console.error(xhr.responseText); 
            }
        });
    }
    function fetchData(id) {
        $('.error_span').hide();
        let csrfToken = '{{csrf_token()}}';
        $.ajax({
            type: 'POST',
            url: '{{ route("student.data") }}',
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
                console.error(xhr.responseText); 
            }
        });
    }
    function deleteStudent(id) {
        swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this record!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            let csrfToken = '{{csrf_token()}}';
            $.ajax({
                type: 'POST',
                url: '{{ route("student.delete") }}',
                data: {'id':id,'_token':csrfToken},
                success: function(response) {
                    swal("Success! Your record has been deleted!", {
                        icon: "success",
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); 
                }
            });
            
        } else {
            swal("Your record is safe!");
        }
        });
        
    }
</script>

</body>
</html>