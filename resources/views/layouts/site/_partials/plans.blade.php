@php
    $whatsapp_link = 'https://api.whatsapp.com/send?phone=5591988203132&text=Ol%C3%A1%20venho%20do%20site%20buzzin%20e%20quero%20assinar%20o%20plano%20'
@endphp

<section id="pricing" class="py-20 m-h-screen" data-section="">
    <div class="c-container">
        <div class="w-content text-center mx-auto">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Plano que melhor se adapta a você</h2>
            <p class="text-gray-400 leading-relaxed">
                Escolha o plano que melhor se encaixa as necessidades do seu negócio
            </p>
        </div>
        <div class="pricingTable mt-10">
            <div class="flex flex-col lg:flex-row my-5 lg:space-x-4 space-y-8">
                <template></template>

                @foreach ($plans as $plan)
                    <div class="flex-1 flex-1 md:w-2/3 md:mx-auto lg:w-auto">
                        <div class="card card--col" id="Basic">
                            <div class="card__header">
                                <div class="flex items-center justify-between">
                                    <h3 class="card__title">{{ $plan->name }}</h3><template><span
                                            class="badge"></span></template>
                                    @if (@$plan->recomended)
                                        <span class="badge">Recomendado</span>
                                    @endif
                                </div>
                                <div class="card__price"><span class="price-currency mr-2">R$</span> <span
                                        class="price-value">{{ $plan->getPriceBrAttribute() }}</span> <span
                                        class="price-period">
                                    </span>
                                </div>
                            </div>
                            <div class="card__features">
                                @foreach ($plan->details as $feature)
                                    <p class="feature">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span x-text="feature">{{ $feature->name }}</span>
                                    </p>
                                @endforeach
                            </div>
                            <div class="card__footer text-center my-4"><a href="{{ env('DISABLE_AUTO_SIGN') ? $whatsapp_link . $plan->name : route('subscription', $plan->url)}}"
                                {{ env('DISABLE_AUTO_SIGN') ? 'target="_blank"' : ''}}
                                    class="button button--filled button--primary">Assinar Agora Mesmo<svg
                                        class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg></a></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
