<html>
<head>
</head>
<body>
<div class="container">
<h2>Application which is able to get the reach of a specific tweet</h2>

    {!! Form::open(['url' => '/']) !!}
    {!! Form::label('url', 'Tweet URL', ['class' => 'awesome']) !!}
    {!! Form::text('url', $url?:'') !!}
    {!! Form::token() !!}
    {!! Form::submit('Get') !!}
    {!! Form::close() !!}

    <p>

        {!! $reach ?$reach->reach(): '' !!}
    </p>
</div>

</body>
</html>