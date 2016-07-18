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
					<th>Nome</th>
					<th>Ação</th>
				</tr>
			</thead>
			<tbody>
				@foreach($categories as $c)
					<tr>
						<td>{{$c->id}}</td>
						<td>{{$c->name}}</td>
						<td>
							<a href="{{ route('admin.categories.edit', ['id'=>$c->id]) }}" class="btn btn-default btn-sm">{{--<i class="fa fa-pencil"/>--}}Editar</a>
							<a href="{{ route('admin.categories.destroy', ['id'=>$c->id]) }}" class="btn btn-danger btn-sm">{{--<i class="fa fa-pencil"/>--}}Remover</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		{!! $categories->render()  !!}

	</div>

@endsection
