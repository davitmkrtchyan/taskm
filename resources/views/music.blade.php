@extends('layouts.app')

@section('content')
    <div class="container">
        <button id="latina">Latina</button>
        <div id="frame-container" class="col-md-8">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/PT2_F-1esPk?list=PLFgquLnL59alCl_2TQvOiD5Vgm1hCaGSI" frameborder="0" allowfullscreen id="music-frame"></iframe>
        </div>
        <div id="categories-music" class="col-md-4">
            <h4>Categories</h4>
        </div>
    </div>
@endsection