@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					New Product
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
						    	{!! Form::select('store_id', $stores, null, ['class' => 'form-control','placeholder' => 'Select a Store']) !!}
						    </div>
						</div>
						
						<div class="form-group">
						    {!! Form::Label('location', 'Current Location',['class' => 'col-sm-3 control-label']) !!}
						    <div class="col-sm-6">
						    	{!! Form::select('location_id', $locations, null, ['class' => 'form-control','placeholder' => 'Select a Location']) !!}
						    </div>
						</div>
						
						<div class="form-group">
						    {!! Form::Label('source', 'Source',['class' => 'col-sm-3 control-label']) !!}
						    <div class="col-sm-6">
						    	{!! Form::select('source_id', $sources, null, ['class' => 'form-control','placeholder' => 'Select a Source']) !!}
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
								{!! Form::text('sale_price', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Shipping Paid</label>

							<div class="col-sm-6">
								{!! Form::text('shipping_paid', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Actual Shipping</label>

							<div class="col-sm-6">
								{!! Form::text('actual_shipping', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Seller Fee</label>

							<div class="col-sm-6">
								{!! Form::text('seller_fee', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Shipping Fee</label>

							<div class="col-sm-6">
								<input type="text" name="shipping_fee" id="task-name" class="form-control" value="{{ old('shipping_fee') }}">
								{!! Form::text('shipping_fee', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Transaction Fee</label>

							<div class="col-sm-6">
								<input type="text" name="transaction_fee" id="task-name" class="form-control" value="{{ old('transaction_fee') }}">
							</div>
						</div>

						<!-- Add Task Button -->
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-6">
								<button type="submit" class="btn btn-default">
									<i class="fa fa-btn fa-plus"></i>Add Product
								</button>
							</div>
						</div>
					{!! Form::close() !!}
					<form action="/product/{{ $product->id }}" method="POST">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						<button type="submit" id="delete-task-{{ $product->id }}" class="btn btn-danger">
							<i class="fa fa-btn fa-trash"></i>Delete
						</button>
					</form>
				</div>
			</div>

		</div>
	</div>
@endsection