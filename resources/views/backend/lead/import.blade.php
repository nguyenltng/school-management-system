<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Lead @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Import Lead
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Lead</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <div class="col-md-6">
                            <div class="card-body">
                                <form action="{{ route('lead.import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                      
                                    @if (count($errors) > 0)
                                        <div class="row">
                                            <div class="col-md-8 col-md-offset-1">
                                            <div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                                                @foreach($errors->all() as $error)
                                                {{ $error }} <br>
                                                @endforeach      
                                            </div>
                                            </div>
                                        </div>
                                    @endif
                      
                                    @if (Session::has('success'))
                                        <div class="row">
                                          <div class="col-md-8 col-md-offset-1">
                                            <div class="alert alert-success alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <h5>{!! Session::get('success') !!}</h5>   
                                            </div>
                                          </div>
                                        </div>
                                    @endif
                      
                                    <input type="input" name="stage" value="{{AppHelper::STUDENT_STAGE['LEAD']}}" hidden>
                                    <input type="file" name="file" class="form-control">

                                    <br>
                                    <button class="btn btn-success">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
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
        $(document).ready(function () {
            window.postUrl = '{{URL::Route("student.status", 0)}}';
            Academic.studentInit();
        });
    </script>
@endsection
<!-- END PAGE JS-->
