@if ($message = Session::get('success'))    {{-- green --}}
    <flash
        :message="{{ json_encode(['text' => $message, 'type' => 'success', 'timer' => 3000]) }}"
    ></flash>
@elseif ($message = Session::get('fail'))   {{-- red --}}
    <flash
        :message="{{ json_encode(['text' => $message, 'type' => 'error', 'timer' => null]) }}"
    ></flash>
@elseif ($message = Session::get('warning'))    {{-- yellow --}}
    <flash
        :message="{{ json_encode(['text' => $message, 'type' => 'warning', 'timer' => null]) }}"
    ></flash>
@elseif ($message = Session::get('info'))   {{-- blue --}}
    <flash
        :message="{{ json_encode(['text' => $message, 'type' => 'info', 'timer' => null]) }}"
    ></flash>
@else
    <flash></flash> {{--for ajax response--}}
@endif
