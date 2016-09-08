@extends('app')

@section('content')
	<div class="container">
		<h3>Pedidos</h3>

		{{--<a href="{{ route('admin.orders.create') }}" class="btn btn-default">Novo pedido</a>--}}
		<br/><br/>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Cliente</th>
					<th>Entregador</th>
					<th>Total</th>
					<th>Ação</th>
				</tr>
			</thead>
			<tbody>
				@foreach($orders as $o)
					<tr>
						<td>{{$o->id}}</td>
						<td>{{$o->client->user->name}}</td>
						<td>{{$o->deliveryman->name}}</td>
						<td>{{$o->total}}</td>
						<td>
							<a href="{{ route('admin.orders.show', ['id'=>$o->id]) }}" class="btn btn-default btn-sm"><i class="fa fa-eye"/>Ver</a>
							{{--<a href="{{ route('admin.order.edit', ['id'=>$o->id]) }}" class="btn btn-default btn-sm"><i class="fa fa-pencil"/>Editar</a>--}}
							{{--<a href="{{ route('admin.products.destroy', ['id'=>$p->id]) }}" class="btn btn-danger btn-sm">--}}{{--<i class="fa fa-pencil"/>--}}{{--Remover</a>--}}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

	</div>

@endsection
