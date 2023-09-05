<div class="alert alert-{{ $type }} {{ $canClose ?  'alert-dismissible' : '' }} {{ @$class }} fade show" role="alert">
    {!! $message !!}
    @if ($canClose)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>