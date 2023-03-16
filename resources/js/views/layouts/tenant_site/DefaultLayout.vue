<template>
    <Header />
    <div class="mt-2 mb-3">
        <div class="slot mt-4">
            <PreloaderComponent />
            <slot name="content">
            </slot>
        </div>
    </div>
    <Footer />
</template>

<script>
import Header from './_partials/Header.vue';
import Footer from './_partials/Footer.vue';
import PreloaderComponent from '../../../components/common/PreloaderComponent.vue';

export default {
    components: {
        Header,
        Footer,
        PreloaderComponent
    }
}
</script>