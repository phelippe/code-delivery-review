@extends('app')

@section('content')
	<div class="container">
		<h3>Novo pedido</h3>

		@include('errors._check')

		{!! Form::open(['route'=> 'customer.products.store']) !!}

			@include('customer.products._form')

			<div class="form-group">
				{!! Form::submit('Realizar pedido', ['class'=>'btn btn-primary']) !!}
			</div>

		{!! Form::close() !!}

	</div>

@endsection
