<div class="form-group">
	{!! Form::label('status', 'Estado: ') !!}
	{!! Form::select('status', $list_status, null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
	{!! Form::label('user_deliveryman_id', 'Entregador: ') !!}
	{!! Form::select('user_deliveryman_id', $deliveryman, null, ['class'=>'form-control']) !!}
</div>