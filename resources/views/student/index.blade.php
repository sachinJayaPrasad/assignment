@extends('common.layouts')
@section('content')
<div style="margin-left:250px;"> 
    <div class="container"> 
        <h3 class="text-success pt-3">STUDENTS LIST</h3>
        <button class="btn-sm btn-success mb-1" style="float:right" data-toggle="modal" data-target="#addModal" >
            ADD NEW
        </button>
        <table class="table table-bordered table-hover table-striped mt-3">
            <thead>
                <th>Id</th>
                <th>Name</th>
                <th>Age </th>
                <th>Gender</th>
                <th>Reporting Teacher</th>
                <th>Action</th>
            </thead>
            <tbody>    
                @foreach ($students as $row)  
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->name ?? '' }}</td>
                    <td>{{ $row->age ?? '' }}</td>
                    <td>{{ $row->gender ?? '' }}</td>
                    <td>{{ $row->teacher_name ?? '' }}</td>
                    <td >
                        <a href="javascript:;" data-id="{{ $row->id }}" class="edit-button" data-bs-toggle="modal" data-bs-target="#addModal" title="edit"><button class="btn btn-info fa fa-pencil tx-20 mr-1"></button></a>
                        <a href="javascript:;" data-id="{{ $row->id }}" class="fa fa-trash-alt tx-20 openDelModal"><button class="btn btn-danger fa fa-trash tx-20 mr-1"></button></a>
                    </td>
                </tr>
                @endforeach  
            </tbody>  
        </table>
        {{-- Add Modal  --}}
        <div class="modal fade" id="addModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center tx-primary" id="myModalLabel">Add Student</h4>
                    </div>
                    <form id="add-student" action="javascript:;">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name:<span class="tx-danger">*</span></label>
                                <input type="hidden" name="student_id" id="student_id">
                                <input class="form-control" id="name" name="name" type="text" placeholder="Enter Student Name"/>
                            </div>
                            <div class="form-group">
                                <label>Age:<span class="tx-danger">*</span></label>
                                <input class="form-control" id="age" name="age" type="text" placeholder="Enter Student Age"/>
                            </div>
                            <div class="form-group">
                                <label>Gender: <span class="tx-danger">*</span></label>
                                <select class="form-control " name="gender" id="gender">
                                    <option value="">Select</option>
                                    <option value="MALE">Male</option>
                                    <option value="FEMALE">Female</option>
                                    <option value="OTHER">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Reporting Teacher: <span class="tx-danger">*</span></label>
                                <select class="form-control " name="teacher" id="teacher">
                                    <option value="">Select</option>
                                    @foreach($teachers as $tutor)
                                        <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-sm btn-info bg-purple tx-white closeBtn" onclick="window.location.reload();" > Close </button>
                            <button type="submit" class="btn-sm btn-success addBtn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Add Modal  --}}
        <!-- Reject Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content delete-popup">
                        <div class="modal-header">
                            <h4 class="modal-title tx-danger">Delete Student</h4>
                        </div>
                        <form action="javascript:;" id="delete-form">
                            <div class="modal-body">
                                Are you sure you want to delete this Student?
                                <input type="hidden" name="student_id" id="studentId">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default bg-purple tx-white closeBtn" onclick="window.location.reload();">Cancel</button>
                                <button type="button" id="deleteBtn" class="btn btn-danger reject-class">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <!-- End Reject Modal -->   
    </div>
</div>
@endsection
@section('scripts')
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.0/moment-with-locales.min.js"></script>
<script>
    $(document).ready(function(){
        const url = '{{url("/")}}';
        //Delete Function
        $('body').on('click','.openDelModal',function(){
            let id = $(this).attr('data-id');
            $('#studentId').val(id);
            $('#deleteModal').modal()
        });
        $('body').on('click','#deleteBtn',function(){
            let id = $('#studentId').val();
            $.ajax({
                url : url+"/delete-student/"+id,
                type : "GET",
                processData : false,
                async : true,
                header : {
                    "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')
                },
                success : function(data){
                    if(data.status === true){
                        toastr["success"](data.response)
                        setTimeout(() => {
                            window.location.href=""
                        },500);
                    }else{
                        toastr["error"](data.response);
                    }
                }
            })
            return false
        })
        //Edit  Funcion
        $('body').on('click','.edit-button',function(){
            let dataId = $(this).attr("data-id") ;
            $.ajax({
                url : url+"/edit-student/"+dataId,
                type : "GET",
                processData : false,
                async : true,
                header : {
                    "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')
                },
                success : function(data){
                    if(data.status === true){
                        $('#myModalLabel').text('Edit Student');
                        $('#student_id').val(data.response.id);
                        $('#teacher').val(data.response.teacher_id);
                        $('#name').val(data.response.name);
                        $('#age').val(data.response.age);
                        $('#gender').val(data.response.gender);
                        $('#addModal').modal();
                    }else{
                        toastr["error"](data.response);
                    }
                }
            })
            return false
        })
        //Adding function
        $('#add-student').validate({
            normalizer : function(value){
                return $.trim(value)
            },
            ignore: [],
            rules : {
                name : {
                    required : true,
                    maxlength : 50
                },
                age : {
                    required : true,
                    number : true
                },
                gender : {
                    required : true,
                },
            },
            messages : {
                first_name : {
                    required : "Enter Student Name",
                    maxlength : "Name Must be not more than 50 characters"
                },
                age : {
                    required : "Please Enter Students Age",
                    number : "Age must be a numeric value"
                },
                gender : {
                    required : "Gender is required",
                },
            },
            submitHandler : function(form){
                var form = document.getElementById('add-student');
                var formData = new FormData(form)
                $('.closeBtn').prop('disabled', true)
                $('.addBtn').prop('disabled', true)
                $.ajax({
                    url  : '{{ route("add_student") }}',
                    type : "POST",
                    data : formData,
                    processData: false,
                    dataType: "json",
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    async: true,
                    headers : {
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $(".addBtn").text("Processing..");
                    },
                    success : function(data){
                        $('.addBtn').text("Submit")
                        $('.closeBtn').prop('disabled', false)
                        $('.addBtn').prop('disabled', false)
                        if(data.status == 1){
                            toastr["success"](data.response)
                            setTimeout(() => {
                                window.location.href=""
                            },1000);
                        }else{
                            var html =""
                            $.each(data.response,function(key,value){
                                html += value + '</br>';
                            });
                            toastr["error"](html);
                        }
                    }
                })
            }
        })
    })
</script>
@endsection