@extends('layouts.adminMaster')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('public/js/plugins/nestable/css/style2.css') }}">
<ul class="breadcrumb">
	<li>Home</li>
	<li>Food Types</li>
</ul>
<div class="panel panel-success">
	<div class="panel-heading">
		<h2 class="panel-title">Here is some type of all the food will display</h2>
	</div>
	<div class="panel-body">
		<div class="container">
			<div class="col-lg-1"></div>
			<div class="col-lg-8 dd" id="nestable">
				<table class="table table-bordered table-hover mb-1" >
					<thead>
						<td width="5%"></td>
						<td class="text-center" width="5%">STT</td>
						<td>Type</td>
						<td class="text-center">In Use</td>
						<td class="text-center" width="10%">Options</td>
					</thead>
					<tbody class="dd-list">
						@foreach($listType as $key => $v)
						<tr class="dd-item" data-id="{{ $key+1 }}">
							<td class="dd-handle"><i class="fa fa-minus"></i></td>
							<td class="text-center">{{ $key+1 }}</td>
							<td><input type="text" name="types[]" id="{{ $v['id'] }}" value="{{ $v['types'] }}" class="edit-able food-type"></td>
							<td class="text-center">{{ $v['in_use'] }}</td>
							<td class="text-center"><button type="button" value="{{ $v['id'] }}" class="btn btn-xs btn-warning confirm-delete"><span class="glyphicon glyphicon-remove"></span></button></td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<div class="col-md-1 pull-right p-0">
					<button type="button" name="addLine" class="btn btn-sm pull-right btn-success"><i class="fa fa-plus"></i></button>
				</div>
			</div>
			
		</div>
	</div>
</div>
<div class="message-box animated fadeIn" data-sound="alert" id="mb-confirm-delete">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-sign-out"></span><strong>Delete</strong> ?</div>
            <div class="mb-content">
                <p>This action will remove type info from <span id="warn" class="label label-danger"></span> foods product.</p>                
                <p>Are you sure you want to delete this?</p>
            </div>
            <div class="mb-footer">
                <div class="pull-right">
                <form action="{{ route('type.confirm') }}" method="post">
                	{{ csrf_field() }}
                    <button type="submit" name="typeId" class="btn btn-success btn-lg">Yes</button>
                    <button type="button" class="btn btn-default btn-lg mb-control-close">No</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('public/js/plugins/nestable/js/nestable.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/process/type.js') }}"></script>
<script type="text/javascript">
	$('.dd').nestable();
</script>
@endsection