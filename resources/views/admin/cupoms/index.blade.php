@extends('app')

@section('content')
	<div class="container">
		<h3>Categorias</h3>

		<a href="{{ route('admin.categories.create') }}" class="btn btn-default">Nova categoria</a>
		<br/><br/>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Código</th>
					<th>Valor</th>
					<th>Ação</th>
				</tr>
			</thead>
			<tbody>
				@foreach($cupoms as $c)
					<tr>
						<td>{{$c->id}}</td>
						<td>{{$c->code}}</td>
						<td>{{$c->value}}</td>
						<td>
							<a href="{{ route('admin.cupoms.edit', ['id'=>$c->id]) }}" class="btn btn-default btn-sm">{{--<i class="fa fa-pencil"/>--}}Editar</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		{!! $cupoms->render()  !!}

	</div>

@endsection
