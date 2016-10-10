@extends('layouts.app')

@section('content')
    {{--<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>--}}
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>

    <style type="text/css">
        #messages{
            border: 1px solid gainsboro;
            height: 300px;
            margin-bottom: 8px;
            overflow-x: hidden;
            padding: 5px;
        }
        .message-div{
            border-bottom: 1px solid gainsboro;
        }
    </style>

    <div class="container spark-screen">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Chat Message Module</div>

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-12" >
                                <div id="messages" >
                                    @if($messages !== "")
                                    @foreach($messages as $message)
                                        <strong>{{ $message->sender_name }}</strong>
                                        <p class="message-div">{{ $message->message }} <span class="pull-right">{{$message->timestamp}}</span></p>
                                    @endforeach
                                        @else
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12" >
                                <form action="sendmessage" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                    <input type="hidden" name="user" value="{{ Auth::user()->name }}" >
                                    <textarea class="form-control msg"></textarea>
                                    <br/>
                                    <input type="button" value="Send" class="btn btn-success send-msg">
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var socket = io.connect('http://localhost:8890');

        socket.on('message', function (data) {
            var currentdate = new Date();
            var datetime = currentdate.getFullYear() + "-"
                    + (currentdate.getMonth()+1)  + "-"
                    + currentdate.getDate() + " "
                    + currentdate.getHours() + ":"
                    + currentdate.getMinutes() + ":"
                    + currentdate.getSeconds();
            data = jQuery.parseJSON(data);
            $( "#messages" ).prepend( "<strong>"+data.user+"</strong><p class='message-div'>"+data.message+"<span class='pull-right'>" + datetime + "</span></p>" );
        });

        $(".send-msg").click(function(e){
            e.preventDefault();
            var token = $("input[name='_token']").val();
            var user = $("input[name='user']").val();
            var msg = $(".msg").val();

            if(msg != ''){
                $.ajax({
                    type: "POST",
                    url: '{!! URL::to("sendmessage") !!}',
                    dataType: "json",
                    data: {'_token':token,'message':msg,'user':user},
                    success:function(data){
                        $(".msg").val('');
                    }
                });
            }else{
                alert("Please Add Message.");
            }
        })
    </script>
@endsection
