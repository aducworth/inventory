@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					New Store
				</div>

				<div class="panel-body">
					<!-- Display Validation Errors -->
					@include('common.errors')

					<form action="/store" method="POST" class="form-horizontal">
						{{ csrf_field() }}

						<!-- Task Name -->
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Store</label>

							<div class="col-sm-6">
								<input type="text" name="name" id="task-name" class="form-control" value="{{ old('store') }}">
							</div>
						</div>

						<!-- Add Task Button -->
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-6">
								<button type="submit" class="btn btn-default">
									<i class="fa fa-btn fa-plus"></i>Add Store
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<!-- Current Tasks -->
			@if (count($stores) > 0)
				<div class="panel panel-default">
					<div class="panel-heading">
						Current Stores
					</div>

					<div class="panel-body">
						<table class="table table-striped task-table">
							<thead>
								<th>Store</th>
								<th>&nbsp;</th>
							</thead>
							<tbody>
								@foreach ($stores as $store)
									<tr>
										<td class="table-text"><div>{{ $store->name }}</div></td>

										<!-- Task Delete Button -->
										<td>
											<form action="/store/{{ $store->id }}" method="POST">
												{{ csrf_field() }}
												{{ method_field('DELETE') }}

												<button type="submit" id="delete-task-{{ $store->id }}" class="btn btn-danger">
													<i class="fa fa-btn fa-trash"></i>Delete
												</button>
											</form>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			@endif
		</div>
	</div>
@endsection