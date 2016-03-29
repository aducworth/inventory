@extends('layouts.app')

@section('content')

	<div class="container">
			
			@include('common.errors')
			
			<div class="container">
			
				<form class="form-inline">
				  <div class="form-group">
					  {!! Form::Label('from_date', 'From') !!}
					  <div class='col-sm-6'>
						{!! Form::text('from_date', (isset($_GET['from_date'])?$_GET['from_date']:null), ['class' => 'form-control','id' => 'from-date','placeholder' => 'From']) !!}
					  </div>
				  </div>
				  <div class="form-group">
					  {!! Form::Label('to_date', 'To') !!}
					  <div class='col-sm-6'>
						{!! Form::text('to_date', (isset($_GET['to_date'])?$_GET['to_date']:null), ['class' => 'form-control','id' => 'to-date','placeholder' => 'To']) !!}
					  </div>
						<script type="text/javascript">
				            $(function () {
					            $('#from-date').datetimepicker({'format':'MM/DD/YYYY'});
					            
				                $('#to-date').datetimepicker({
					                'format':'MM/DD/YYYY',
					                useCurrent: false //Important! See issue #1075
					             });
					             
					             $("#from-date").on("dp.change", function (e) {
						            $('#to-date').data("DateTimePicker").minDate(e.date);
						        });
						        $("#to-date").on("dp.change", function (e) {
						            $('#from-date').data("DateTimePicker").maxDate(e.date);
						        });
				            });
				        </script>
				  </div>
				  <button type="submit" class="btn btn-default">Filter</button>
				</form>
				
				<br>
			
			</div>
			
			@if (count($snapshots) > 0)
				<div class="panel panel-default">
					<div class="panel-heading">
						Snapshots ( <a href="/snapshot/gallery?from_date=<?=(isset($_GET['from_date'])?$_GET['from_date']:'') ?>&to_date=<?=(isset($_GET['to_date'])?$_GET['to_date']:'') ?>">Gallery</a> )
						<a href="{!! route('snapshot.create') !!}" class='pull-right'>+New Snapshot</a>
					</div>

					<div class="panel-body">
						
						<div class="table-responsive">
							
							<table class="table table-striped task-table">
								<thead>
									<th>Date</th>
									<th>Image</th>								
									<th>&nbsp;</th>
								</thead>
								<tbody>
									@foreach ($snapshots as $snapshot)
										<tr>
											<td class="table-text"><div>{{ date( 'm/d/Y', strtotime( $snapshot->created_at ) ) }}</div></td>
											<td>
												@if ($snapshot->snapshot_url)
												<a href='https://s3.amazonaws.com/charlestontreasures{{ $snapshot->snapshot_url }}' target='_blank'>
													<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
												</a>
												@endif
											</td>
											
											<td>
												 <a href="{!! route('snapshot.edit', array($snapshot->id)) !!}" class='btn btn-default pull-right'>Edit</a>
											</td>
											
										</tr>
										
									@endforeach
								</tbody>
							</table>
						
						</div>
						
					</div>
				</div>
			@else
				<div class="alert alert-info" role="alert">No snapshots currently in the database.<a href="{!! route('snapshot.create') !!}" class='pull-right'>+New Snapshot</a></div>
			@endif

	</div>
@endsection