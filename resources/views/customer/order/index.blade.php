@extends('app')

@section('content')
	<div class="container">
		<h3>Meus pedidos</h3>

		<a href="{{route('customer.order.create')}}" class="btn btn-default">Novo pedido</a>
		<br><br>
		<table class="table table-bordered">
			<thead>
			<tr>
				<th>Id</th>
				<th>Total</th>
				<th>Status</th>
			</tr>
			</thead>
			<tbody>
			@foreach($orders as $order)
				<tr>
					<td>{{$order->id}}</td>
					<td>{{$order->total}}</td>
					<td>{{$order->status}}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		{!! $orders->render() !!}

	</div>

@endsection

@section('post-script')
	<script>
		$('#btn-new-item').on('click', function(){
			var row = $('table tbody > tr:last'),
				newRow = row.clone(),
				length = $('table tbody tr').length;

			newRow.find('td').each(function(){
				var td = $(this),
					input = td.find('input, select'),
					name = input.attr('name');

				input.attr('name', name.replace( (length-1) + '', length+''));
			});

			newRow.find('input').val(1);
			newRow.insertAfter(row);
			calculateTotal();
		});

		$(document.body).on('click select', function(){
			calculateTotal();
		});

		$('input[name*=qtd]').on('blur', function(){
			calculateTotal();
		});

		function calculateTotal(){
			var total = 0,
				trLen = $('table tbody tr').length,
				tr = null, price, qtd;

			for(var i = 0 ; i<trLen ; i++){
				tr = $('table tbody tr').eq(i);
				price = tr.find(':selected').data('price');
				qtd = tr.find('input').val();
				total +=price*qtd;
			}
			$('#total').html(total);
		}
	</script>
@endsection