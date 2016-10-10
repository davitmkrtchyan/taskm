@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

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
                        <form action="{{ url('/create') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                            <div class="form-group">
                                <label for="task" class="col-sm-3 control-label">New Task</label>

                                <div class="col-sm-6">
                                    <input type="text" name="name" id="task-name" class="form-control">
                                </div>
                            </div>

                            <!-- Add Task Button -->
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-plus"></i> Add Task
                                    </button>
                                </div>
                            </div>
                        </form>

                        @if (count($tasks) > 0)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    All Tasks
                                </div>

                                <div class="panel-body">
                                    <table class="table table-striped task-table">

                                        <!-- Table Body -->
                                        <tbody>
                                        @foreach ($tasks as $task)
                                            <tr>
                                                <!-- Task Name -->
                                                <td class="table-text">
                                                    <div>{{ $tasksCount-- }}. {{ $task->name }}</div>
                                                </td>

                                                <!-- Delete Button -->
                                                <td>

                                                    <form action="/task/delete/{{ $task->id }}" method="POST" id="deleteForm">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button class="btn btn-info delete-button">
                                                            <i class="icon-trash icon-white"></i>
                                                            End Task
                                                        </button>
                                                    </form>
                                                    {{--<form action="/task/edit/{{ $task->id }}" method="POST" id="editForm">--}}
                                                        {{--{{ csrf_field() }}--}}
                                                        {{--<button class="btn btn-info delete-button">--}}
                                                            {{--<i class="icon-trash icon-white"></i>--}}
                                                            {{--Edit--}}
                                                        {{--</button>--}}
                                                    {{--</form>--}}
                                                </td>
                                            </tr>
                                        @endforeach
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
