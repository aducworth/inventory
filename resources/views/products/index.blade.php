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

					<form action="/product" method="POST" class="form-horizontal">
						{{ csrf_field() }}

						<!-- Product Name -->
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Product</label>

							<div class="col-sm-6">
								<input type="text" name="name" id="task-name" class="form-control" value="{{ old('product') }}">
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Purchase Price</label>

							<div class="col-sm-6">
								<input type="text" name="purchase_price" id="task-name" class="form-control" value="{{ old('purchase_price') }}">
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Sale Price</label>

							<div class="col-sm-6">
								<input type="text" name="sale_price" id="task-name" class="form-control" value="{{ old('sale_price') }}">
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Shipping Paid</label>

							<div class="col-sm-6">
								<input type="text" name="shipping_paid" id="task-name" class="form-control" value="{{ old('shipping_paid') }}">
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Actual Shipping</label>

							<div class="col-sm-6">
								<input type="text" name="actual_shipping" id="task-name" class="form-control" value="{{ old('actual_shipping') }}">
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Seller Fee</label>

							<div class="col-sm-6">
								<input type="text" name="seller_fee" id="task-name" class="form-control" value="{{ old('seller_fee') }}">
							</div>
						</div>
						
						<div class="form-group">
							<label for="task-name" class="col-sm-3 control-label">Shipping Fee</label>

							<div class="col-sm-6">
								<input type="text" name="shipping_fee" id="task-name" class="form-control" value="{{ old('shipping_fee') }}">
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
					</form>
				</div>
			</div>

			<!-- Current Tasks -->
			@if (count($products) > 0)
				<div class="panel panel-default">
					<div class="panel-heading">
						Current Products
					</div>

					<div class="panel-body">
						<table class="table table-striped task-table">
							<thead>
								<th>Product</th>
								<th>&nbsp;</th>
							</thead>
							<tbody>
								@foreach ($products as $product)
									<tr>
										<td class="table-text"><div>{{ $product->name }}</div></td>

										<!-- Task Delete Button -->
										<td>
											<form action="/product/{{ $product->id }}" method="POST">
												{{ csrf_field() }}
												{{ method_field('DELETE') }}

												<button type="submit" id="delete-task-{{ $product->id }}" class="btn btn-danger">
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