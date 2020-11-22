<div>
	<h3>From components/header.blade.php</h3>
	<h4>Hi {{$name}} </h4>
	<ul>
	@foreach($fruit as $fr)
		<li>{{$fr}}</li>
		@endforeach
	</ul>	
</div>