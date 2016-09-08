@extends('app')

@section('content')
	<div class="container">
		<h3>Pedido {{$order->id}}</h3>

		<br/><br/>

		<table class="table table-bordered">
			<thead>
			<tr>
				<th>ID</th>
				<th>Cliente</th>
				<th>Entregador</th>
				<th>Itens</th>
				<th>Total</th>
				<th>Ação</th>
			</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{$order->id}}</td>
					<td>{{$order->client->user->name}}</td>
					<td>{{$order->deliveryman->name}}</td>
					<td>
						<ul>
						@foreach($order->items as $i)
							<li>{{$i->product->name}}</li>
						@endforeach
						</ul>
					</td>
					<td>{{$order->total}}</td>
					<td>
						<a href="{{ route('admin.orders.edit', ['id'=>$order->id]) }}" class="btn btn-default btn-sm"><i class="fa fa-pencil"/>Editar</a>
						{{--<a href="{{ route('admin.products.destroy', ['id'=>$p->id]) }}" class="btn btn-danger btn-sm">--}}{{--<i class="fa fa-pencil"/>--}}{{--Remover</a>--}}
					</td>
				</tr>
			</tbody>
		</table>

	</div>

@endsection
