@extends('layouts.admin')

@section('title')
Project Name | Manage Page
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        CMS
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">CMS</a></li>
        <li class="active">Manage Pages</li>
    </ol>
    <div class="col-xs-12">
        @if(Session::has('alert-success'))
        <div class="callout callout-success alert-dismissible alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            <p>{{ Session::get('alert-success') }}</p>
        </div>
        @endif

        @if(Session::has('alert-error'))
        <div class="callout callout-danger alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Error!</h4>
            {{ Session::get('alert-error') }}
        </div>
        @endif
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Pages</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    
                    <!-- ______________________Top Level Pages_______________________ -->
                    <div class="topLevelPage">
                        <h4>Top Level Pages</h4>
                        <div class="topLevelPageContent">
                            @if(count($topLevel))
                            <!-- /.col -->
                            <div class="col-md-12 SubSortableTable">
                                @foreach ($topLevel as $topLevelPage)
                                <div class="groupTableContent">
                                    <div class="SubSortableTableContent box box-default collapsed-box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{$topLevelPage->name}}</h3>
                                            <span class="order hide">{{$topLevelPage->id}}</span>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <!-- /.box-header -->

                                        <div class="box-body">
                                            <div class="weekly_manage_btn">
                                                <span class="pull-right">
                                                    {{ Form::open(array('url' => 'admin/page/' . $topLevelPage->id, 'class'=> 'pull-right')) }}
                                                    {{ Form::hidden('_method', 'DELETE') }}
                                                    {{ Form::button('<i class="glyphicon glyphicon-trash"></i>Delete', array('class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => "Delete Page", 'data-message' => "Are you sure you want to delete this page?"))}}
                                                    {{ Form::close() }}
                                                </span>
                                                <span class="pull-right">
                                                    <a href="{{url('admin/page/'.$topLevelPage->id.'/edit')}}"><button class="btn btn-xs btn-default"><i class="glyphicon glyphicon-edit"></i>Edit</button></a>
                                                </span>
                                            </div>
                                            <!-- /.col -->

                                            <table class="table weekly_data_table table-striped table-hover">
                                                <tr>
                                                    <th>Page Location</th>
                                                    <td>{{$topLevelPage->location}}</td>
                                                </tr>

                                                <tr>
                                                    <th>Page URL</th>
                                                    <td>{{$url}}/{{$topLevelPage->url}}</td>
                                                </tr>

                                                <tr>
                                                    <th>Navigation Label</th>
                                                    <td>{{$topLevelPage->navigation_label}}</td>
                                                </tr>

                                                <tr>
                                                    <th>Content</th>
                                                    <td>{{$topLevelPage->content}}</td>
                                                </tr>

                                                <tr>
                                                    <th>Active</th>
                                                    <td>
                                                        @if($topLevelPage->status)
                                                        yes
                                                        @else
                                                        no
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>

                                            <!-- /.col -->
                                        </div>
                                        <!-- /.box-body -->

                                    </div>
                                    @if(!empty($topLevelPage->subs))
                                    <div class="childTableSorting">
                                        @foreach ($topLevelPage->subs as $topSubLevelPage)
                                        <div class="SubSortableTableContent childtablecontent box box-default collapsed-box">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">{{$topSubLevelPage->name}}</h3>
                                                <span class="order hide">{{$topSubLevelPage->id}}</span>
                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <!-- /.box-header -->

                                            <div class="box-body">
                                                <div class="weekly_manage_btn">
                                                    <span class="pull-right">
                                                        {{ Form::open(array('url' => 'admin/page/' . $topSubLevelPage->id, 'class'=> 'pull-right')) }}
                                                        {{ Form::hidden('_method', 'DELETE') }}
                                                        {{ Form::button('<i class="glyphicon glyphicon-trash"></i>Delete', array('class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => "Delete Page", 'data-message' => "Are you sure you want to delete this page?"))}}
                                                        {{ Form::close() }}
                                                    </span>
                                                    <span class="pull-right">
                                                        <a href="{{url('admin/page/'.$topSubLevelPage->id.'/edit')}}"><button class="btn btn-xs btn-default"><i class="glyphicon glyphicon-edit"></i>Edit</button></a>
                                                    </span>
                                                </div>
                                                <!-- /.col -->

                                                <table class="table weekly_data_table table-striped table-hover">
                                                    <tr>
                                                        <th>Page Location</th>
                                                        <td>{{$topSubLevelPage->location}}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Page URL</th>
                                                        <td>{{$url}}/{{$topSubLevelPage->url}}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Navigation Label</th>
                                                        <td>{{$topSubLevelPage->navigation_label}}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Content</th>
                                                        <td>{{$topSubLevelPage->content}}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Active</th>
                                                        <td>
                                                            @if($topSubLevelPage->status)
                                                            yes
                                                            @else
                                                            no
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>

                                                <!-- /.col -->
                                            </div>
                                            <!-- /.box-body -->

                                        </div>

                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="col-md-12">
                                <p class="bg-warning" style="text-align:center; padding: 10px">There is no record</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- ______________________Bottom Level Pages_______________________ -->
                    <div class="topLevelPage">
                        <h4>Footer Location Pages</h4>
                        <div class="topLevelPageContent">
                            @if(count($footerLevel))
                            <!-- /.col -->
                            <div class="col-md-12 SubSortableTable">
                                @foreach ($footerLevel as $footerLevelPage)
                                <div class="groupTableContent">
                                    <div class="SubSortableTableContent box box-default collapsed-box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{$footerLevelPage->name}}</h3>
                                            <span class="order hide">{{$footerLevelPage->id}}</span>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <!-- /.box-header -->

                                        <div class="box-body">
                                            <div class="weekly_manage_btn">
                                                <span class="pull-right">
                                                    {{ Form::open(array('url' => 'admin/page/' . $footerLevelPage->id, 'class'=> 'pull-right')) }}
                                                    {{ Form::hidden('_method', 'DELETE') }}
                                                    {{ Form::button('<i class="glyphicon glyphicon-trash"></i>Delete', array('class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => "Delete Page", 'data-message' => "Are you sure you want to delete this page?"))}}
                                                    {{ Form::close() }}
                                                </span>
                                                <span class="pull-right">
                                                    <a href="{{url('admin/page/'.$footerLevelPage->id.'/edit')}}"><button class="btn btn-xs btn-default"><i class="glyphicon glyphicon-edit"></i>Edit</button></a>
                                                </span>
                                            </div>
                                            <!-- /.col -->

                                            <table class="table weekly_data_table table-striped table-hover">
                                                <tr>
                                                    <th>Page Location</th>
                                                    <td>{{$footerLevelPage->location}}</td>
                                                </tr>

                                                <tr>
                                                    <th>Page URL</th>
                                                    <td>{{$url}}/{{$footerLevelPage->url}}</td>
                                                </tr>

                                                <tr>
                                                    <th>Navigation Label</th>
                                                    <td>{{$footerLevelPage->navigation_label}}</td>
                                                </tr>

                                                <tr>
                                                    <th>Content</th>
                                                    <td>{{$footerLevelPage->content}}</td>
                                                </tr>

                                                <tr>
                                                    <th>Active</th>
                                                    <td>
                                                        @if($footerLevelPage->status)
                                                        yes
                                                        @else
                                                        no
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>

                                            <!-- /.col -->
                                        </div>
                                        <!-- /.box-body -->

                                    </div>
                                    @if(!empty($footerLevelPage->subs))
                                    <div class="childTableSorting">
                                        @foreach ($footerLevelPage->subs as $footerSubLevelPage)
                                        <div class="SubSortableTableContent childtablecontent box box-default collapsed-box">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">{{$footerSubLevelPage->name}}</h3>
                                                <span class="order hide">{{$footerSubLevelPage->id}}</span>
                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <!-- /.box-header -->

                                            <div class="box-body">
                                                <div class="weekly_manage_btn">
                                                    <span class="pull-right">
                                                        {{ Form::open(array('url' => 'admin/page/' . $footerSubLevelPage->id, 'class'=> 'pull-right')) }}
                                                        {{ Form::hidden('_method', 'DELETE') }}
                                                        {{ Form::button('<i class="glyphicon glyphicon-trash"></i>Delete', array('class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => "Delete Page", 'data-message' => "Are you sure you want to delete this page?"))}}
                                                        {{ Form::close() }}
                                                    </span>
                                                    <span class="pull-right">
                                                        <a href="{{url('admin/page/'.$footerSubLevelPage->id.'/edit')}}"><button class="btn btn-xs btn-default"><i class="glyphicon glyphicon-edit"></i>Edit</button></a>
                                                    </span>
                                                </div>
                                                <!-- /.col -->

                                                <table class="table weekly_data_table table-striped table-hover">
                                                    <tr>
                                                        <th>Page Location</th>
                                                        <td>{{$footerSubLevelPage->location}}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Page URL</th>
                                                        <td>{{$url}}/{{$footerSubLevelPage->url}}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Navigation Label</th>
                                                        <td>{{$footerSubLevelPage->navigation_label}}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Content</th>
                                                        <td>{{$footerSubLevelPage->content}}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Active</th>
                                                        <td>
                                                            @if($footerSubLevelPage->status)
                                                            yes
                                                            @else
                                                            no
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>

                                                <!-- /.col -->
                                            </div>
                                            <!-- /.box-body -->

                                        </div>

                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="col-md-12">
                                <p class="bg-warning" style="text-align:center; padding: 10px">There is no record</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- Modal Dialog -->
<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Delete Parmanently</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure about this ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirm">Delete</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        $('.SubSortableTable').sortable({
            helper: fixWidthHelper,
            start: function (event, ui) {
                var start_pos = ui.item.index();
                ui.item.data('start_pos', start_pos);
            },
            update: function (event, ui) {
                var order = [];

                $('.SubSortableTableContent').each(function () {
                    order.push($(this).children().children('span.order').text());
                });

                var data = order.join(',');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                    }
                });
                $.ajax({
                    url: '<?php echo $url; ?>' + '/admin/page/order/change',
                    type: 'POST',
                    data: {'order': data},
                    success: function () {

                    }
                });
                console.log(order);
            },
            axis: 'y'
        }).disableSelection();


        $('.childTableSorting').sortable({
            helper: fixWidthHelper,
            start: function (event, ui) {
                var start_pos = ui.item.index();
                ui.item.data('start_pos', start_pos);
            },
            update: function (event, ui) {
                var order = [];

                $('.SubSortableTableContent').each(function () {
                    order.push($(this).children().children('span.order').text());
                });

                var data = order.join(',');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
                    }
                });
                $.ajax({
                    url: '<?php echo $url; ?>' + '/admin/page/order/change',
                    type: 'POST',
                    data: {'order': data},
                    success: function () {

                    }
                });
                console.log(order);
            },
            axis: 'y'
        }).disableSelection();


        /*---delete confirmation----*/
        /*-- Dialog show event handler --*/
        $('#confirmDelete').on('show.bs.modal', function (e) {
            $message = $(e.relatedTarget).attr('data-message');

            $(this).find('.modal-body p').text($message);
            $title = $(e.relatedTarget).attr('data-title');
            $(this).find('.modal-title').text($title);

            // Pass form reference to modal for submission on yes/ok
            var form = $(e.relatedTarget).closest('form');
            $(this).find('.modal-footer #confirm').data('form', form);
        });

        /*-- Form confirm (yes/ok) handler, submits form --*/
        $('#confirmDelete').find('.modal-footer #confirm').on('click', function () {
            $(this).data('form').submit();
        });
    });



    function fixWidthHelper(e, ui) {
        ui.children().each(function () {
            $(this).width($(this).width());
        });
        return ui;
    }
</script>
<!-- /.content -->
@endsection 