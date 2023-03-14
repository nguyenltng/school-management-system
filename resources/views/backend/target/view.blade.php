<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') student Profile @endsection
<!-- End block -->

<!-- Page body extra css -->
@section('extraStyle')
    <style>
        @media print {
            @page {
                size:  A4 landscape;
                margin: 0;
            }
        }
    </style>
@endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        @notrole('Student')
        <div class="btn-group">
            <a href="#"  class="btn-ta btn-sm-ta btn-print btnPrintInformation"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="btn-group">
            <a href="{{URL::route('target.edit',$student->id)}}" class="btn-ta btn-sm-ta"><i class="fa fa-edit"></i> Edit</a>
        </div>

        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{URL::route('target.index')}}"><i class="fa icon-student"></i> Target</a></li>
            <li class="active">View</li>
        </ol>
        @endnotrole
        @role('Student')
        <h1>
            Academic Details
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Academic</li>
        </ol>
        @endrole
    </section>

    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="box box-info">
                            <div class="box-body box-profile">
                                <img class="profile-user-img img-responsive img-circle" src="@if($student->photo ){{ asset('storage/student')}}/{{ $student->photo }} @else {{ asset('images/avatar.jpg')}} @endif">
                                <h3 class="profile-username text-center">{{$student->name ?? ''}}</h3>
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item" style="background-color: #FFF">
                                        <b>Registration No.</b> <a class="pull-right">{{$student->regi_no ?? ''}}</a>
                                    </li>
                                    <li class="list-group-item" style="background-color: #FFF">
                                        <b>ID Card No.</b> <a class="pull-right">{{$student->card_no ?? ''}}</a>
                                    </li>
                                    <li class="list-group-item" style="background-color: #FFF">
                                        <b>Phone</b> <a class="pull-right">{{$student->phone_no ?? ''}}</a>
                                    </li>
                                    <li class="list-group-item" style="background-color: #FFF">
                                        <b>Email</b> <a class="pull-right">{{$student->email ?? ''}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#information" data-toggle="tab">Profile</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="information">
                            <p class="text-info" style="font-size: 16px;border-bottom: 1px solid #eee;">Personal Info:</p>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Full Name</label>
                                </div>
                                <div class="col-md-3">
                                    {{-- <p for="">: {{$student->name ?? ''}} @if(strlen($student->nick_name))[{{$student->nick_name ?? ''}}]@endif</p> --}}
                                </div>
                                <div class="col-md-3">
                                    <label for="">Date of Birth</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->dob ?? ''}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Gender</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->gender ?? ''}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Source</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->source ?? ''}} </p> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Compaign</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->compaign ?? ''}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Nationality</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->nationality ?? ''}}</p>
                                </div>
                            </div>
                                <div class="row">
                                <div class="col-md-3">
                                    <label for="">Email</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->email ?? ''}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Phone No.</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->phone_no ?? ''}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Extra Curricular Activities </label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->extra_activity ?? ''}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Note</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->note ?? ''}}</p>
                                </div>
                            </div>
                            <p class="text-info" style="font-size: 16px;border-bottom: 1px solid #eee;">Parents Info:</p>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Father Name </label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->father_name ?? ''}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Father Phone No.</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->father_phone_no ?? ''}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Mother Name </label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->mother_name ?? ''}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Mother Phone No.</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->mother_phone_no ?? ''}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Guardian Name </label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->guardian ?? ''}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Guardian Phone No.</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->guardian_phone_no ?? ''}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Present Address </label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->present_address ?? ''}}</p>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Permanent Address</label>
                                </div>
                                <div class="col-md-3">
                                    <p for="">: {{$student->permanent_address ?? '' }}</p>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
    <!-- /.content -->
@endsection
<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE JS-->
@section('extraScript')
    <script type="text/javascript">
        // window.attendanceUrl = '{{route('public.get_student_attendance')}}';
        // window.marksUrl = '{{route('public.get_student_result')}}';
        // window.subjectUrl = '{{route('public.get_student_subject')}}';
        // $(document).ready(function () {
        //    Academic.studentProfileInit();
        // });
    </script>
@endsection
<!-- END PAGE JS-->
