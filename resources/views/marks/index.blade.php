@extends('common.layouts')
@section('content')
<div style="margin-left:250px;"> 
    <div class="container"> 
        <h3 class="text-success pt-3">MARK LIST</h3>
        <button class="btn-sm btn-success mb-1" style="float:right" data-toggle="modal" data-target="#addModal" >
            ADD NEW
        </button>
        <table class="table table-bordered table-hover table-striped mt-3">
            <thead>
                <th>Id</th>
                <th>Name</th>
                <th>Maths </th>
                <th>Science</th>
                <th>History</th>
                <th>Term</th>
                <th>Total Marks</th>
                <th>Created On</th>
                <th>Action</th>
            </thead>
            <tbody>    
                @foreach ($marklists as $row)  
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->student_name ?? '' }}</td>
                    <td>{{ $row->marks_maths ?? '' }}</td>
                    <td>{{ $row->marks_science ?? '' }}</td>
                    <td>{{ $row->marks_history ?? '' }}</td>
                    @if($row->term == 1)
                        <td>One</td>
                    @elseif($row->term == 2)
                        <td>Two</td>
                    @else
                        <td>Three</td>
                    @endif
                    @php
                        $total_marks = $row->marks_science + $row->marks_maths + $row->marks_history
                    @endphp
                    <td>{{ $total_marks ?? '' }}</td>
                    <td>{{ date('M-d-Y',strtotime($row->created_at)) ?? '' }}</td>
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
                        <h4 class="modal-title text-center tx-primary" id="myModalLabel">Add Marks for Student</h4>
                    </div>
                    <form id="add-mark" action="javascript:;">
                        <div class="modal-body">
                            <input type="hidden" name="mark_id" id="mark_id">
                            <div class="form-group">
                                <label>Student: <span class="tx-danger">*</span></label>
                                <select class="form-control " name="student_id" id="student_id">
                                    <option value="">Select</option>
                                    @foreach($students as $stud)
                                        <option value="{{ $stud->id }}">{{ $stud->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Term: <span class="tx-danger">*</span></label>
                                <select class="form-control " name="term" id="term">
                                    <option value="">Select</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-danger">Add student marks for different subjects <span class="tx-danger">*</span></label>
                            </div>
                            <div class="form-group">
                                <label>Maths:<span class="tx-danger">*</span></label>
                                <input class="form-control" name="marks_maths" id="marks_maths" type="text" placeholder="Enter Maths Mark"/>
                            </div>
                            <div class="form-group">
                                <label>Science:<span class="tx-danger">*</span></label>
                                <input class="form-control" name="marks_science" id="marks_science" type="text" placeholder="Enter Science Mark"/>
                            </div>
                            <div class="form-group">
                                <label>Maths:<span class="tx-danger">*</span></label>
                                <input class="form-control" name="marks_history" id="marks_history" type="text" placeholder="Enter History Mark"/>
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
                            <h4 class="modal-title tx-danger">Delete Marks</h4>
                        </div>
                        <form action="javascript:;" id="delete-form">
                            <div class="modal-body">
                                Are you sure you want to delete this Marklist?
                                <input type="hidden" name="mark_id" id="markId">
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
            $('#markId').val(id);
            $('#deleteModal').modal()
        });
        $('body').on('click','#deleteBtn',function(){
            let id = $('#marktId').val();
            $.ajax({
                url : url+"/delete-marks/"+id,
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
                url : url+"/edit-marks/"+dataId,
                type : "GET",
                processData : false,
                async : true,
                header : {
                    "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')
                },
                success : function(data){
                    if(data.status === true){
                        $('#myModalLabel').text('Edit Mark for Student');
                        $('#mark_id').val(data.response.id);
                        $('#student_id').val(data.response.student_id);
                        $('#term').val(data.response.term);
                        $('#marks_maths').val(data.response.marks_maths);
                        $('#marks_science').val(data.response.marks_science);
                        $('#marks_history').val(data.response.marks_history);
                        $('#addModal').modal();
                    }else{
                        toastr["error"](data.response);
                    }
                }
            })
            return false
        })
        //Adding function
        $('#add-mark').validate({
            normalizer : function(value){
                return $.trim(value)
            },
            ignore: [],
            rules : {
                student_id : {
                    required : true,
                },
                term : {
                    required : true,
                },
            },
            messages : {
                student_id : {
                    required : "Please select a student",
                },
                term : {
                    required : "Select a term",
                },
            },
            submitHandler : function(form){
                var form = document.getElementById('add-mark');
                var formData = new FormData(form)
                $('.closeBtn').prop('disabled', true)
                $('.addBtn').prop('disabled', true)
                $.ajax({
                    url  : '{{ route("add_marks") }}',
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