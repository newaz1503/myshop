<template>
    <div class="">
        <stripe-checkout
            ref="checkoutRef"
            :pk="publishableKey"
            :sessionId="sessionId"
            mode="payment"
        />
        <button @click="submit">Pay now!</button>
    </div>
</template>

<script>
    import { StripeCheckout} from '@vue-stripe/vue-stripe';
    export default {
        components: { StripeCheckout},
        data () {
            return {
                publishableKey:null,
                sessionId:null
            };
        },
        mounted() {
          axios.get('/stripe/create-session').then(res => {
              this.sessionId = res.data.sessionId.id;
              this.publishableKey = res.data.pk;
          }).catch(error => {
              console.log(error)
          });
        },
        methods: {
            submit () {
                // You will be redirected to Stripe's secure checkout page
                this.$refs.checkoutRef.redirectToCheckout();
            },
        },
    }
</script>

<style scoped>

</style>
