@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="col-md-12">
            <div class="col-md-6">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                    New article
                </button>
            </div>
            <div class="col-md-6 text-right">
                {{ $news->links() }}
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <img src="{{ URL::asset('images/png/42.gif')}}" alt="preloader" id="preloader-article">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Create new article</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('/news/add') }}" method="POST" id="addArticle">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="url">URL:</label>
                                <input type="text" class="form-control" id="url" placeholder="URL" name="url">
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Name" name="name">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" id="description" placeholder="Description" name="description">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="Publish" value="Publish" form="addArticle" id="publish-article">
                    </div>
                </div>
            </div>
        </div>
        @foreach($news as $article)
            <div class="col-md-4 news-div text-center">
                <div class="col-md-10 col-md-offset-1 news-div-inner">
                    <div class="col-md-12">
                        <a href="{{ $article->url }}" target="_blank">
                            <b>{{ $article->name }}</b>
                        </a>
                    </div>
                    <div class="col-md-12" id="description-article">
                        <a href="{{ $article->url }}" target="_blank">
                            {{ $article->description }}
                        </a>
                    </div>
                    <div class="col-md-12 article-img">
                        <a href="{{ $article->url }}" target="_blank">
                            <img src="{{ URL::asset('images/'.$article->img_name) }}" alt="{{ $article->img_name }}" />
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>


@endsection