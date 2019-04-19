<!DOCTYPE html>
<html lang="it-IT">
<head>
    <meta charset="utf-8">
</head>
<body>
	<p>Errore su {{config('maguttiCms.website.option.app.name')}}</p>

	<h3>Error:</h3>
	<pre>{{$error}}</pre>

	<h3>File:</h3>
	<pre>{{$file}}: {{$line}}</pre>

	<h3>Stack trace:</h3>
	<table style="font-size: 0.8em; border-spacing: 10px; border-collapse: separate;">
		<thead>
			<tr>
				<th>Function</th>
				<th>File or Class</th>
				<th>Line</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($trace as $_trace)
					<tr>
						<td>{{$_trace['function']}}</td>
						@if (array_key_exists('file', $_trace))
							<td>{{$_trace['file']}}</td>
						@elseif (array_key_exists('class', $_trace))
							<td>{{$_trace['class']}}</td>
						@else
							<td></td>
						@endif
						<td>{{array_key_exists('line', $_trace)? $_trace['line']: ''}}</td>
					</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>
