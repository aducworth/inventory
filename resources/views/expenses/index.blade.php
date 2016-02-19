@extends('layouts.app')

@section('content')

	<div class="container">
			
			@include('common.errors')
			
			<div class="container">
			
				<form class="form-inline">
				  <div class="form-group">
				    {!! Form::select('store', $stores, (isset($_GET['store'])?$_GET['store']:null), ['class' => 'form-control','placeholder' => 'All Stores']) !!}
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
			
			@if (count($expenses) > 0)
				<div class="panel panel-default">
					<div class="panel-heading">
						Expenses
						<a href="{!! route('expense.create') !!}" class='pull-right'>+New Expense</a>
					</div>

					<div class="panel-body">
						<table class="table table-striped task-table">
							<thead>
								<th>Date</th>
								<th>Amount</th>
								<th>Stores</th>
								<th>Receipt</th>
								<th>&nbsp;</th>
							</thead>
							<tbody>
								@foreach ($expenses as $expense)
									<tr>
										<td class="table-text"><div>{{ date( 'm/d/Y', strtotime( $expense->purchase_date ) ) }}</div></td>
										<td class="table-text"><div>${{ $expense->amount }}</div></td>
										<td class="table-text"><div>{{ $expense->store->name }}</div></td>
										
										<td>
											@if ($expense->receipt_url)
											<a href='https://s3.amazonaws.com/charlestontreasures{{ $expense->receipt_url }}' target='_blank'>
												<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
											</a>
											@endif
										</td>
										<td>
											 <a href="{!! route('expense.edit', array($expense->id)) !!}" class='btn btn-default pull-right'>Edit</a>
										</td>
										
									</tr>
									
									<? $total += $expense->amount; ?>
									
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
			@else
				<div class="alert alert-info" role="alert">No expenses currently in the database.<a href="{!! route('expense.create') !!}" class='pull-right'>+New Expense</a></div>
			@endif

	</div>
@endsection