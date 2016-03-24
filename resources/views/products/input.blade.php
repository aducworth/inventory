@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					{!! $product->id?'Edit':'New' !!} Product
				</div>

				<div class="panel-body">
					<!-- Display Validation Errors -->
					@include('common.errors')

					{!! Form::model($product,['route' => 'product.store','class' => 'form-horizontal']) !!}
					
						{{ csrf_field() }}
						
						{!! Form::hidden('id') !!}

						<!-- Product Name -->
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Product</label>

							<div class="col-sm-6">
								{!! Form::text('name', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						
						<div class="form-group">
						    {!! Form::Label('store', 'Store',['class' => 'col-sm-3 control-label']) !!}
						    <div class="col-sm-6">
						    	{!! Form::select('store_id', $stores, (isset($_GET['store'])?$_GET['store']:null), ['class' => 'form-control calculate-fees','placeholder' => 'Select a Store','id' => 'store-id']) !!}
						    </div>
						</div>
						
						<div class="form-group">
						    {!! Form::Label('location', 'Current Location',['class' => 'col-sm-3 control-label']) !!}
						    <div class="col-sm-6">
						    	{!! Form::select('location_id', $locations, (isset($_GET['location'])?$_GET['location']:null), ['class' => 'form-control','placeholder' => 'Select a Location']) !!}
						    </div>
						</div>
						
						<div class="form-group">
						    {!! Form::Label('source', 'Source',['class' => 'col-sm-3 control-label']) !!}
						    <div class="col-sm-6">
						    	{!! Form::select('source_id', $sources, (isset($_GET['source'])?$_GET['source']:null), ['class' => 'form-control','placeholder' => 'Select a Source']) !!}
						    </div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Purchase Price</label>

							<div class="col-sm-6">
								{!! Form::text('purchase_price', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Sale Price</label>

							<div class="col-sm-6">
								{!! Form::text('sale_price', null, ['class' => 'form-control calculate-fees','id' => 'sale-price']) !!}
							</div>
						</div>
						
						<div class="form-group online-sales-only">
							<label for="task-name" class="col-sm-3 control-label">Shipping Paid</label>

							<div class="col-sm-6">
								{!! Form::text('shipping_paid', null, ['class' => 'form-control calculate-fees','id' => 'shipping-paid']) !!}
							</div>
						</div>
						
						<div class="form-group online-sales-only">
							<label for="task-name" class="col-sm-3 control-label">Actual Shipping</label>

							<div class="col-sm-6">
								{!! Form::text('actual_shipping', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Seller Fee</label>

							<div class="col-sm-6">
								{!! Form::text('seller_fee', null, ['class' => 'form-control','id' => 'seller-fee']) !!}
							</div>
						</div>
						
						<div class="form-group online-sales-only">
							<label for="task-name" class="col-sm-3 control-label">Shipping Fee</label>

							<div class="col-sm-6">
								{!! Form::text('shipping_fee', null, ['class' => 'form-control','id' => 'shipping-fee']) !!}
							</div>
						</div>
						
						<div class="form-group online-sales-only">
							<label for="task-name" class="col-sm-3 control-label">Transaction Fee</label>

							<div class="col-sm-6">
								{!! Form::text('transaction_fee', null, ['class' => 'form-control','id' => 'transaction-fee']) !!}
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Quantity</label>

							<div class="col-sm-6">
								{!! Form::text('quantity', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Quantity Sold</label>

							<div class="col-sm-6">
								{!! Form::text('quantity_sold', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						
						<div class="form-group">
						    {!! Form::Label('product_status', 'Status',['class' => 'col-sm-3 control-label']) !!}
						    <div class="col-sm-6">
						    	{!! Form::select('product_status', $product_statuses, null, ['class' => 'form-control']) !!}
						    </div>
						</div>
						
						<div class="form-group">
						    {!! Form::Label('improvement_hours', 'Improvement Hours',['class' => 'col-sm-3 control-label']) !!}
						    <div class="col-sm-6">
						    	{!! Form::text('improvement_hours', null, ['class' => 'form-control']) !!}
						    </div>
						</div>
						
						<div class="form-group">
						    {!! Form::Label('improvement_dollars', 'Improvement $',['class' => 'col-sm-3 control-label']) !!}
						    <div class="col-sm-6">
						    	{!! Form::text('improvement_dollars', null, ['class' => 'form-control']) !!}
						    </div>
						</div>

						<!-- Add Task Button -->
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-6">
								<button type="submit" name='submit' class="btn btn-default" value="Save">
									<i class="fa fa-btn fa-plus"></i>Save Product
								</button>
								<br><br>
								<button type="submit" name='submit' class="btn btn-default" value="SaveAdd">
									<i class="fa fa-btn fa-plus"></i>Save Product and Add Another
								</button>
							</div>
						</div>
					{!! Form::close() !!}
					
					<script>
					
					$(document).ready(function(){
						
						checkIfOnline();
						
						$('.calculate-fees').on('change', function() {
							var seller_fee 		= 0;
							var shipping_fee 	= 0;
							var transaction_fee = 0;
							var changed			= $(this).attr('name');
							var store			= $('#store-id option:selected').text();
							
							if( store == 'eBay' ) {
								seller_fee 			= $('#sale-price').val() * 0.1;
								shipping_fee 		= $('#shipping-paid').val() * 0.1;
								transaction_fee		= ( Number($('#sale-price').val()) + Number($('#shipping-paid').val()) ) * 0.03;
							} else if( store == 'Amazon' ) {
								seller_fee 			= ( Number($('#sale-price').val()) * 0.25 ) + 3;
								shipping_fee 		= 0;
								transaction_fee		= 0;
							} else {
								seller_fee 			= Number($('#sale-price').val()) *0.1;
								shipping_fee 		= 0;
								transaction_fee		= 0;
							}
						    
						    $('#seller-fee').val(seller_fee.toFixed(2));
						    $('#shipping-fee').val(shipping_fee.toFixed(2));
						    $('#transaction-fee').val(transaction_fee.toFixed(2));
						    
						});
						
						$('#store-id').on('change', function() {
							
							checkIfOnline();
							
						});
					
					});
					
					function checkIfOnline() {
						
						var store = $('#store-id option:selected').text();
						
						if( store == 'eBay' || store == 'Amazon' ) {
							
							$('.online-sales-only').show();
							
						} else {
							
							$('.online-sales-only').hide();
							
						}
						
					}
					
					</script>
					
					@if ($product->id)
					<form action="/product/{{ $product->id }}" method="POST" class='pull-right' onsubmit="return confirm('Are you sure?')">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						<button type="submit" id="delete-task-{{ $product->id }}" class="btn btn-danger">
							<i class="fa fa-btn fa-trash"></i>Delete
						</button>
					</form>
					@endif
				</div>
			</div>

		</div>
	</div>
@endsection