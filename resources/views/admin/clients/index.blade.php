@extends('app')

@section('content')
	<div class="container">
		<h3>Clientes</h3>

		<a href="{{ route('admin.clients.create') }}" class="btn btn-default">Novo cliente</a>
		<br/><br/>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Nome</th>
					<th>E-mail</th>
					<th>Fone</th>
					<th>Cidade</th>
					<th>Ação</th>
				</tr>
			</thead>
			<tbody>
				@foreach($clients as $c)
					<tr>
						<td>{{$c->id}}</td>
						<td>{{$c->user->name}}</td>
						<td>{{$c->user->email}}</td>
						<td>{{$c->phone}}</td>
						<td>{{$c->city}}</td>
						<td>
							<a href="{{ route('admin.clients.edit', ['id'=>$c->id]) }}" class="btn btn-default btn-sm">{{--<i class="fa fa-pencil"/>--}}Editar</a>
							{{--<a href="{{ route('admin.products.destroy', ['id'=>$c->id]) }}" class="btn btn-danger btn-sm"><i class="fa fa-pencil"/>Remover</a>--}}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		{!! $clients->render()  !!}

	</div>

@endsection
