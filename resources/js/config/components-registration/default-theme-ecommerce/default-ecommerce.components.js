import app from '../../../main';
import homeSiteTenantView from '../../../views/tenant_site/home/home.view.vue';
import cartSiteTenantView from '../../../views/tenant_site/cart/cart.view.vue';
import loginSiteTenantView from '../../../views/tenant_site/login/login.view.vue';
import registerSiteTenantView from '../../../views/tenant_site/register/register.view.vue';
import recoverSiteTenantView from '../../../views/tenant_site/recover/recover.view.vue';
import resetPasswordSiteTenantView from '../../../views/tenant_site/password_reset/password_reset.view.vue';
import checkoutSiteTenantView from '../../../views/tenant_site/checkout/checkout.view.vue';
import maintenceSiteTenantView from '../../../views/tenant_site/maintence/maintence.view.vue';
import ClientSiteTenantView from '../../../views/tenant_site/client/index.view.vue';
import preloader from '../../../components/common/PreloaderComponent.vue';


app.component('home-client-view', homeSiteTenantView);
app.component('cart-tenant-view', cartSiteTenantView);
app.component('login-tenant-view', loginSiteTenantView);
app.component('register-tenant-view', registerSiteTenantView);
app.component('recover-tenant-view', recoverSiteTenantView);
app.component('passord-reset-tenant-view', resetPasswordSiteTenantView);

app.component('checkout-tenant-view', checkoutSiteTenantView);
app.component('maintence-sitetenant-view', maintenceSiteTenantView);
app.component('client-tenant-view', ClientSiteTenantView);
app.component('preloader-component', preloader);