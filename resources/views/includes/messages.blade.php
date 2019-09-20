@isset($errors)
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endisset
@foreach (Message::get() as $message)
    <div class="alert alert-{{ $message['type'] }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 
        {!! $message['message'] !!}
    </div>
@endforeach
<div id="messages-js">
</div>