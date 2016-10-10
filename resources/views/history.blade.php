@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">History</div>

                    <div class="panel-body">
                        <!-- Display Validation Errors -->
                        {{--@include('common.errors')--}}

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
                            @endif
                        @endforeach

                    <!-- New Task Form -->

                            @if (count($tasks) > 0)
                                <div class="panel panel-default">

                                    <div class="panel-body">
                                        <table class="table table-striped task-table">
                                            <tbody>
                                            <!-- Delete Button -->
                                            <tr>
                                                <td></td>
                                            <td>

                                                <form action="/history/clear" method="POST" id="deleteForm">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}

                                                    <button class="btn btn-danger delete-button">
                                                        <i class="icon-trash icon-white"></i>
                                                        Clear History
                                                    </button>
                                                </form>
                                            </td>
                                            </tr>

                                            <!-- Table Body -->

                                            @foreach ($tasks as $task)
                                                <tr>
                                                    <!-- Task Name -->
                                                    <td class="table-text">
                                                        <div>{{ $task->id }}. {{ $task->name }}</div>
                                                    </td>
                                                    <td>


                                                        <form action="/history/restore/{{$task->id}}" method="POST" id="restoreHistory">
                                                            {{ csrf_field() }}
                                                            <button class="btn btn-info delete-button">
                                                                <i class="icon-trash icon-white"></i>
                                                                Restore
                                                            </button>
                                                        </form>
                                                    </td>


                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td>
                                                    {!! $tasks->links() !!}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
