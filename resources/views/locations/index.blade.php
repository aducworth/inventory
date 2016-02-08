@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					New Location
				</div>

				<div class="panel-body">
					<!-- Display Validation Errors -->
					@include('common.errors')

					<form action="/location" method="POST" class="form-horizontal">
						{{ csrf_field() }}

						<!-- Task Name -->
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">location</label>

							<div class="col-sm-6">
								<input type="text" name="name" id="task-name" class="form-control" value="{{ old('location') }}">
							</div>
						</div>

						<!-- Add Task Button -->
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-6">
								<button type="submit" class="btn btn-default">
									<i class="fa fa-btn fa-plus"></i>Add location
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<!-- Current Tasks -->
			@if (count($locations) > 0)
				<div class="panel panel-default">
					<div class="panel-heading">
						Current locations
					</div>

					<div class="panel-body">
						<table class="table table-striped task-table">
							<thead>
								<th>location</th>
								<th>&nbsp;</th>
							</thead>
							<tbody>
								@foreach ($locations as $location)
									<tr>
										<td class="table-text"><div>{{ $location->name }}</div></td>

										<!-- Task Delete Button -->
										<td>
											<form action="/location/{{ $location->id }}" method="POST">
												{{ csrf_field() }}
												{{ method_field('DELETE') }}

												<button type="submit" id="delete-task-{{ $location->id }}" class="btn btn-danger">
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