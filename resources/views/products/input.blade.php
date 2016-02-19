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

<!-- 					<form action="/product" method="POST" class="form-horizontal" enctype="multipart/form-data"> -->
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
						    	{!! Form::select('store_id', $stores, null, ['class' => 'form-control calculate-fees','placeholder' => 'Select a Store','id' => 'store-id']) !!}
						    </div>
						</div>
						
						<div class="form-group">
						    {!! Form::Label('location', 'Current Location',['class' => 'col-sm-3 control-label']) !!}
						    <div class="col-sm-6">
						    	{!! Form::select('location_id', $locations, null, ['class' => 'form-control','placeholder' => 'Select a Location']) !!}
						    </div>
						</div>
						
						<div class="form-group">
						    {!! Form::Label('purchase', 'Purchase',['class' => 'col-sm-3 control-label']) !!}
						    <div class="col-sm-6">
						    	{!! Form::select('purchase_id', $purchases, null, ['class' => 'form-control','placeholder' => 'Select a Purchase']) !!}
						    </div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Purchase Price</label>

							<div class="col-sm-6">
								{!! Form::text('purchase_price', 0, ['class' => 'form-control']) !!}
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Sale Price</label>

							<div class="col-sm-6">
								{!! Form::text('sale_price', 0, ['class' => 'form-control calculate-fees','id' => 'sale-price']) !!}
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Shipping Paid</label>

							<div class="col-sm-6">
								{!! Form::text('shipping_paid', 0, ['class' => 'form-control calculate-fees','id' => 'shipping-paid']) !!}
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Actual Shipping</label>

							<div class="col-sm-6">
								{!! Form::text('actual_shipping', 0, ['class' => 'form-control']) !!}
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Seller Fee</label>

							<div class="col-sm-6">
								{!! Form::text('seller_fee', 0, ['class' => 'form-control','id' => 'seller-fee']) !!}
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Shipping Fee</label>

							<div class="col-sm-6">
								{!! Form::text('shipping_fee', 0, ['class' => 'form-control','id' => 'shipping-fee']) !!}
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Transaction Fee</label>

							<div class="col-sm-6">
								{!! Form::text('transaction_fee', 0, ['class' => 'form-control','id' => 'transaction-fee']) !!}
							</div>
						</div>
						
						<div class="form-group">
						    {!! Form::Label('product_status', 'Status',['class' => 'col-sm-3 control-label']) !!}
						    <div class="col-sm-6">
						    	{!! Form::select('product_status', $product_statuses, null, ['class' => 'form-control']) !!}
						    </div>
						</div>

						<!-- Add Task Button -->
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-6">
								<button type="submit" class="btn btn-default">
									<i class="fa fa-btn fa-plus"></i>Save Product
								</button>
							</div>
						</div>
					{!! Form::close() !!}
					
					<script>
					
					$(document).ready(function(){
						
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
					
					});
					
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