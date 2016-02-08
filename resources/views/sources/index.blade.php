@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					New source
				</div>

				<div class="panel-body">
					<!-- Display Validation Errors -->
					@include('common.errors')

					<form action="/source" method="POST" class="form-horizontal">
						{{ csrf_field() }}

						<!-- Task Name -->
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Source</label>

							<div class="col-sm-6">
								<input type="text" name="name" id="task-name" class="form-control" value="{{ old('source') }}">
							</div>
						</div>

						<!-- Add Task Button -->
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-6">
								<button type="submit" class="btn btn-default">
									<i class="fa fa-btn fa-plus"></i>Add source
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<!-- Current Tasks -->
			@if (count($sources) > 0)
				<div class="panel panel-default">
					<div class="panel-heading">
						Current sources
					</div>

					<div class="panel-body">
						<table class="table table-striped task-table">
							<thead>
								<th>source</th>
								<th>&nbsp;</th>
							</thead>
							<tbody>
								@foreach ($sources as $source)
									<tr>
										<td class="table-text"><div>{{ $source->name }}</div></td>

										<!-- Task Delete Button -->
										<td>
											<form action="/source/{{ $source->id }}" method="POST">
												{{ csrf_field() }}
												{{ method_field('DELETE') }}

												<button type="submit" id="delete-task-{{ $source->id }}" class="btn btn-danger">
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