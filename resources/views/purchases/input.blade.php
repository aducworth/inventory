@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					{!! $purchase->id?'Edit':'New' !!} Purchase
				</div>

				<div class="panel-body">
					<!-- Display Validation Errors -->
					@include('common.errors')

					{!! Form::model($purchase,['route' => 'purchase.store','class' => 'form-horizontal','enctype' => 'multipart/form-data']) !!}
					
						{{ csrf_field() }}
						
						{!! Form::hidden('id') !!}
						
						<div class="form-group">
						    {!! Form::Label('source', 'Source',['class' => 'col-sm-3 control-label']) !!}
						    <div class="col-sm-6">
						    	{!! Form::select('source_id', $sources, null, ['class' => 'form-control','placeholder' => 'Select a Source']) !!}
						    </div>
						</div>
												
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Amount</label>

							<div class="col-sm-6">
								{!! Form::text('amount', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Purchase Date</label>

							<div class="col-sm-6 input-group date" id="datetimepicker1">
								{!! Form::text('purchase_date', (isset($purchase->purchase_date)?date('mm/dd/YYYY',strtotime($purchase->purchase_date)):date('mm/dd/YYYY')), ['class' => 'form-control']) !!}
								<span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
							</div>
							<script type="text/javascript">
					            $(function () {
					                $('#datetimepicker1').datetimepicker({'format':'MM/DD/YYYY'});
					            });
					        </script>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Receipt</label>

							<div class="col-sm-6">
								{!! Form::file('receipt_url', null, ['class' => 'form-control']) !!}
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
									<i class="fa fa-btn fa-plus"></i>Save Purchase
								</button>
							</div>
						</div>
					{!! Form::close() !!}
					@if ($purchase->id)
					<form action="/purchase/{{ $purchase->id }}" method="POST" class='pull-right' onsubmit="return confirm('Are you sure?')">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						<button type="submit" id="delete-task-{{ $purchase->id }}" class="btn btn-danger">
							<i class="fa fa-btn fa-trash"></i>Delete
						</button>
					</form>
					@endif
				</div>
			</div>

		</div>
	</div>
@endsection