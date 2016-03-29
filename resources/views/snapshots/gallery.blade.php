@extends('layouts.app')

@section('content')

<!-- Full Page Image Background Carousel Header -->
<header id="myCarousel" class="carousel slide">
    <!-- Indicators -->
    <ol class="carousel-indicators">
	    @if (count($snapshots) > 0)
	    	@foreach ($snapshots as $index => $snapshot)
				<li data-target="#myCarousel" data-slide-to="{{ $index }}" <?=($index == 0)?"class='active'":'' ?>></li>
        	@endforeach
        @endif
    </ol>

    <!-- Wrapper for Slides -->
    <div class="carousel-inner">
	    @if (count($snapshots) > 0)
	    	@foreach ($snapshots as $index => $snapshot)
		        <div class="item <?=($index == 0)?"active":'' ?>">
		            <!-- Set the first background image using inline CSS below. -->
		            <div class="fill" style="background-image:url('https://s3.amazonaws.com/charlestontreasures{{ $snapshot->snapshot_url }}');"></div>
		            <div class="carousel-caption">
		                <h2>{{ date( 'm/d/Y', strtotime( $snapshot->created_at ) ) }}</h2>
		            </div>
		        </div>
			@endforeach
        @endif
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="icon-prev"></span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="icon-next"></span>
    </a>

</header>

@endsection