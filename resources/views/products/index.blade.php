@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
			
			@include('common.errors')
			
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
			@else
				<div class="alert alert-info" role="alert">No products currently in the database.</div>
			@endif
		</div>
	</div>
@endsection