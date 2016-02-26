@extends('layouts.app')

@section('content')

	<div class="container">
			
			@include('common.errors')
			
			<div class="container">
			
				<form class="form-inline">
				  <div class="form-group">
				    {!! Form::select('source', $sources, (isset($_GET['source'])?$_GET['source']:null), ['class' => 'form-control','placeholder' => 'All Sources']) !!}
				  </div>
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
			
			<? $total = 0; ?>
			
			@if (count($purchases) > 0)
				<div class="panel panel-default">
					<div class="panel-heading">
						Purchases
						<a href="{!! route('purchase.create') !!}" class='pull-right'>+New Purchase</a>
					</div>

					<div class="panel-body">
						
						<div class="table-responsive">
							
							<table class="table table-striped task-table">
								<thead>
									<th>Date</th>
									<th>Amount</th>
									<th>Source</th>
									<th>Receipt</th>								
									<th>&nbsp;</th>
								</thead>
								<tbody>
									@foreach ($purchases as $purchase)
										<tr>
											<td class="table-text"><div>{{ date( 'm/d/Y', strtotime( $purchase->purchase_date ) ) }}</div></td>
											<td class="table-text"><div>${{ $purchase->amount }}</div></td>
											<td class="table-text"><div>{{ $purchase->source->name }}</div></td>
											<td>
												@if ($purchase->receipt_url)
												<a href='https://s3.amazonaws.com/charlestontreasures{{ $purchase->receipt_url }}' target='_blank'>
													<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
												</a>
												@endif
											</td>
											
											<td>
												 <a href="{!! route('purchase.edit', array($purchase->id)) !!}" class='btn btn-default pull-right'>Edit</a>
												 <a href="/product/create?purchase={!! $purchase->id !!}" class='btn btn-default pull-right'>Add Product</a> 
											</td>
											
										</tr>
										
										<? $total += $purchase->amount; ?>
										
									@endforeach
								</tbody>
								<tfoot>
									<th>Total</th>
									<th>$<?=number_format( $total, 2 ) ?></th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
								</tfoot>
							</table>
						
						</div>
						
					</div>
				</div>
			@else
				<div class="alert alert-info" role="alert">No purchases currently in the database.<a href="{!! route('purchase.create') !!}" class='pull-right'>+New Purchase</a></div>
			@endif

	</div>
@endsection