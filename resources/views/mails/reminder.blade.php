@extends('mails.mail')

@section('content')
    <h2 style="color: #333;">Weekly Reminder</h2>
    <p>Hey {{$name}},</p>
    
    <p>You've got a few important tasks approaching! Here's an overview of what's coming up this week:</p>
    
    <ul style="list-style: none; padding: 0;">
        @foreach($events as $event)
            <li style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
                <span style="font-weight: bold; font-size: 16px;">{{ $event->title }}</span><br>
                <span style="font-weight: bold; font-size: 14px;">When:</span>
                <span style="font-size: 14px;">{{ $event->start }}</span><br>
                <span style="font-weight: bold; font-size: 14px;">Duration:</span>
                <span style="font-size: 14px;">{{ $event->task->duration }}</span><br>
                <span style="font-weight: bold; font-size: 14px;">Status:</span>
                <span style="font-size: 14px;">{{ $event->task->status }}</span>
            </li>
        @endforeach
    </ul>
    
@endsection
