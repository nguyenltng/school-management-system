<!-- Master page  -->
@extends('backend.layouts.master')

<!-- Page title -->
@section('pageTitle') Target @endsection
<!-- End block -->

<!-- Page body extra class -->
@section('bodyCssClass') @endsection
<!-- End block -->

<!-- BEGIN PAGE CONTENT-->
@section('pageContent')
    <!-- Section header -->
    <section class="content-header">
        <h1>
            Target
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::route('user.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Target</li>
        </ol>
    </section>
    <!-- ./Section header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <div class="col-md-2" hidden>
                            <div class="form-group has-feedback">
                                {!! Form::select('section_id',  ['11' => "Dead", '1' => 'New', '2' => 'In Process'], $status , ['class' => 'form-control select2', 'id' => 'student_list_filter']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group has-feedback">
                                {!! Form::select('status', ['0' => 'All','11' => "Dead", '1' => 'New', '2' => 'In Process'], $status , ['class' => 'form-control select2 student_list_filter', 'required' => 'true']) !!}
                            </div>
                        </div>
                        <div class="box-tools pull-right">
                            <a class="btn btn-info btn-sm" href="{{ URL::route('target.import') }}"><i class="fa fa-plus-circle"></i> Import File</a>
                        </div>
                        <div class="box-tools pull-right">
                            <a class="btn btn-info btn-sm" href="{{ URL::route('target.export') }}"><i class="fa fa-plus-circle"></i> Export File</a>
                        </div>
                        <div class="box-tools pull-right">
                            <a class="btn btn-info btn-sm" href="{{ URL::route('target.create') }}"><i class="fa fa-plus-circle"></i> Add New</a>
                        </div> 
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                        <table id="listDataTableWithSearch" class="table table-bordered table-striped list_view_table display responsive no-wrap" width="100%">
                            <thead>
                            <tr>
                                <th width="4%">Code</th>
                                <th width="8%">Name</th>
                                <th width="16%">Phone</th>
                                <th width="20%">Activities</th>
                                <th width="8%">Email</th>
                                <th width="8%">Status</th>
                                <th width="8%">Source</th>
                                <th width="10%">Note</th>
                                <th width="8%">Compaign</th>
                                <th class="notexport" width="10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{ $student->code ?? '' }}</td>
                                    <td>{{ $student->name ?? '' }}</td>
                                    <td>{{ $student->phone_no ?? ''}}</td>
                                    <td>{{ $student->extra_activity ?? ''}}</td>
                                    <td>{{ $student->email ?? ''}}</td>
                                    <td>
                                        @if($student->status == '1') 
                                            <span class="badge-status bg-green">
                                                New
                                            </span>
                                        @elseif($student->status == '2')
                                            <span class="badge-status bg-blue">
                                                In Process
                                            </span>
                                        @elseif($student->status == '11')
                                            <span class="badge-status bg-gray">
                                                Dead
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $student->source ?? ''}}</td>
                                    <td>{{ $student->note ?? ''}}</td>
                                    <td>{{ $student->compaign ?? ''}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a title="Details"  href="{{URL::route('target.show',$student->id)}}"  class="btn btn-primary btn-sm"><i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                        <div class="btn-group">
                                            <a title="Edit" href="{{URL::route('target.edit',$student->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                            </a>
                                        </div>
                                        <!-- todo: have problem in mobile device -->
                                        <div class="btn-group">
                                            <form  class="myAction" method="POST" action="{{URL::route('target.destroy', $student->id)}}">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                    <i class="fa fa-fw fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            {{-- <tfoot>
                                <th width="8%">Name</th>
                                <th width="20%">Phone</th>
                                <th width="20%">Activities</th>
                                <th width="8%">Email</th>
                                <th width="8%">Status</th>
                                <th width="8%">Source</th>
                                <th width="10%">Note</th>
                                <th width="8%">Compaign</th>
                                <th class="notexport" width="10%">Action</th>
                            </tfoot> --}}
                        </table>
                    </div>
                    </div>
                    <!-- /.box-body -->
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
