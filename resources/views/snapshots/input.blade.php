@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					{!! $snapshot->id?'Edit':'New' !!} Snapshot
				</div>

				<div class="panel-body">
					<!-- Display Validation Errors -->
					@include('common.errors')

					{!! Form::model($snapshot,['route' => 'snapshot.store','class' => 'form-horizontal','enctype' => 'multipart/form-data']) !!}
					
						{{ csrf_field() }}
						
						{!! Form::hidden('id') !!}
						
						<div class="form-group">
						    {!! Form::Label('store', 'Store',['class' => 'col-sm-3 control-label']) !!}
						    <div class="col-sm-6">
						    	{!! Form::select('store_id', $stores, null, ['class' => 'form-control','placeholder' => 'Select a Store']) !!}
						    </div>
						</div>
																		
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Image</label>

							<div class="col-sm-6">
								{!! Form::file('snapshot_url', null, ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Notes</label>

							<div class="col-sm-6">
								{!! Form::textarea('notes', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-6">
								<button type="submit" class="btn btn-default">
									<i class="fa fa-btn fa-plus"></i>Save Snapshot
								</button>
							</div>
						</div>
					{!! Form::close() !!}
					@if ($snapshot->id)
					<form action="/snapshot/{{ $snapshot->id }}" method="POST" class='pull-right' onsubmit="return confirm('Are you sure?')">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						<button type="submit" id="delete-task-{{ $snapshot->id }}" class="btn btn-danger">
							<i class="fa fa-btn fa-trash"></i>Delete
						</button>
					</form>
					@endif
				</div>
			</div>

		</div>
	</div>
@endsection