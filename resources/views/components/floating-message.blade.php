@if (isset($error))
    <div class="custom-message-success">
        <i class="fas fa-check-circle"></i>
        {!! $error !!}
    </div>
@endif