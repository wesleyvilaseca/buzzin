@if (Session::get('tenant')?->site->isDomain && !Session::get('tenant')?->site->hasRecaptcha)
    <div class="container">
        @component('components.widget.warning', [
            'canClose' => false,
            'class' => 'mt-5',
            'type' => 'warning',
            'message' => '<small>Atenção lojista, Configure o recaptcha</small>',
        ])
        @endcomponent
    </div>
@endif
