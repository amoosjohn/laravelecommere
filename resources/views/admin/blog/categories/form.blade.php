<div class="form-group">
    {!! Form::label('Name') !!}
    {!! Form::text('name', null , array('class' => 'form-control','required') ) !!}
</div>
<div class="form-group">
    {!! Form::label('description') !!}
    {!! Form::textarea('description', null, ['size' => '105x3','class' => 'form-control']) !!} 

</div>
<div class="form-group">
    {!! Form::label('url') !!}
    {!! Form::text('url', null , array('class' => 'form-control','required') ) !!}
</div>
<div class="form-group">
    {!! Form::label('image') !!}
    {!! Form::file('image', null, 
    array('class'=>'form-control')) !!}
</div>