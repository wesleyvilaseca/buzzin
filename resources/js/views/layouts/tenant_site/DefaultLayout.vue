<template>
    <div>
        <Header />
        <div class="mt-4 mb-3">
            <slot name="content">
            </slot>
        </div>
        <Footer />
    </div>
</template>

<script>
import Header from './_partials/Header.vue';
import Footer from './_partials/Footer.vue';

export default {
    components: {
        Header,
        Footer
    }
}
</script>