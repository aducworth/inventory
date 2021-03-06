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
				    {!! Form::select('source', $sources, (isset($_GET['source'])?$_GET['source']:null), ['class' => 'form-control','placeholder' => 'All Sources']) !!}
				  </div>
				  <div class="form-group">
				    {!! Form::select('status', $statuses, (isset($_GET['status'])?$_GET['status']:null), ['class' => 'form-control','placeholder' => 'All Statuses']) !!}
				  </div>
				  <button type="submit" class="btn btn-default">Filter</button>
				  <br>
				  <br>
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
				  
				</form>
				
				<br>
			
			</div>
			
			
			@if (count($products) > 0)
			
			<form class="form-inline" method='post' action='/product/bulk'>
			
				<div class="panel panel-default">
					<div class="panel-heading">
						Products ({!! count($products) !!})
						<a href="{!! route('product.create') !!}" class='pull-right'>+New Product</a>
					</div>

					<div class="panel-body">
						
						<div class="table-responsive">
							
							<table class="table table-striped task-table">
								<thead>
									<th>{!! Form::checkbox('checkall', null, false, ['class' => 'form-control','id' => 'checkall']) !!}</th>
									<th>Product</th>
									<th>Store</th>
									<th>Status</th>
									<th>Qty</th>
									<th>Qty Sold</th>
									<th>Total Cost</th>
									<th>Total Sales</th>
									<th>Total Fees</th>
									<th>Potential Profit</th>
									<th>Profit</th>
									<th>&nbsp;</th>
								</thead>
								<tbody>
								<?
									$total_purchase 	= 0;
									$total_sale			= 0;
									$total_fees			= 0;
									$total_potential 	= 0;
									$total_profit		= 0;
								?>
									@foreach ($products as $product)
									
										<? 
											$fees = ( $product->seller_fee + $product->shipping_fee + $product->transaction_fee );
											$profit = ( ( $product->sale_price + $product->shipping_paid ) - ( $product->purchase_price + $product->actual_shipping + $fees ) ); 
											
											$total_purchase 	+= ( $product->purchase_price * $product->quantity );
											$total_sale			+= ( $product->sale_price * $product->quantity_sold );
											$total_fees			+= ( $fees * $product->quantity );
											$total_potential 	+= ( $profit * $product->quantity );
											$total_profit   	+= ( $profit * $product->quantity_sold );
										?>
										
										<tr>
											<td>{!! Form::checkbox(('products['.$product->id.']'), $product->id, false, ['class' => 'form-control']) !!}</td>
											<td class="table-text"><div>{{ $product->name }}</div></td>
											<td class="table-text"><div>{{ $product->store->name }}</div></td>
											<td class="table-text"><div>{{ $statuses[$product->product_status] }}</div></td>
											<td class="table-text"><div>{{ $product->quantity }}</div></td>
											<td class="table-text"><div>{{ $product->quantity_sold }}</div></td>
											<td class="table-text"><div>$<?=number_format( ( $product->purchase_price * $product->quantity ), 2 ) ?>
											@if ($product->quantity > 1)
											(${{ $product->purchase_price }})
											@endif
											</div>
											</td>
											<td class="table-text"><div>$<?=number_format( ( $product->sale_price * $product->quantity_sold ), 2 ) ?>
											@if ($product->quantity > 1 || $product->quantity_sold == 0)
											(${{ $product->sale_price }})
											@endif
											</div></td>
											<td class="table-text"><div>$<?=number_format( ( $fees * $product->quantity ), 2 ) ?></div></td>
											<td class="table-text"><div>$<?=number_format( ( $profit * $product->quantity ), 2 ) ?>(<?=number_format( ( $product->sale_price / ( $product->purchase_price + $fees ) ) * 100 ) ?>%)</div></td>
											<td class="table-text"><div>$<?=number_format( ( $profit * $product->quantity_sold ), 2 ) ?></div></td>
											
											<!-- Task Delete Button -->
											<td>
												 <a href="{!! route('product.edit', array($product->id)) !!}" class='btn btn-default pull-right'>Edit</a>
											</td>
											
										</tr>
									@endforeach
								</tbody>
								<tfoot>
									<th>&nbsp;</th>
									<th>Totals</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>$<?=number_format( $total_purchase, 2 ) ?></th>
									<th>$<?=number_format( $total_sale, 2 ) ?></th>
									<th>$<?=number_format( $total_fees, 2 ) ?></th>
									<th>$<?=number_format( $total_potential, 2 ) ?>(<?=number_format( ( $total_sale / ( $total_purchase + $total_fees ) ) * 100 ) ?>%)</th>
									<th>$<?=number_format( $total_profit, 2 ) ?></th>
									<th>&nbsp;</th>
								</tfoot>
							</table>
						
						</div>
						
					</div>
				</div>
				
				<div class="form-group">
					{!! Form::Label('bulk_status', 'Add Selected to Status') !!}
			       {!! Form::select('bulk_status', $statuses, null, ['class' => 'form-control','placeholder' => 'Choose Status']) !!}
			    </div>
			    {{ csrf_field() }}
			    <button type="submit" class="btn btn-default">Save</button>
			    
			    <script>
			    
			    $(document).ready(function(){
				    
				    $("#checkall").change(function () {
					    $("input:checkbox").prop('checked', $(this).prop("checked"));
					});
			    
			    });
			    
			    </script>
				
				</form>
			@else
				<div class="alert alert-info" role="alert">No products currently in the database. <a href="{!! route('product.create') !!}" class='pull-right'>+New Product</a></div>
			@endif

	</div>
@endsection