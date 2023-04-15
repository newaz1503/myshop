import Vuex from 'vuex'
import Vue from 'vue'
Vue.use(Vuex)
let cart = window.localStorage.getItem('storeCart');
let cartCount = window.localStorage.getItem('storeCartCount');
export default new Vuex.Store({
    state: {
        cart: cart ? JSON.parse(cart) : [],
        cartCount: cartCount ? parseInt(cartCount) : 0,
    },
    mutations: {
        ADD_TO_CART(state, item) {
            let found = state.cart.find(product => product.id == item.id);
            if (found) {
                found.quantity +=item.quantity;
                found.total_price = found.quantity * found.sale_price;
            } else {
                state.cart.push(item);
                Vue.set(item, 'quantity', item.quantity);
                Vue.set(item, 'total_price', item.sale_price * item.quantity);
                state.cartCount++;
            }
        },
        REMOVE_FROM_CART(state, item) {
            let index = state.cart.indexOf(item);
            if (index > -1) {
                let product = state.cart[index];
                state.cartCount--;
                state.cart.splice(index, 1);
            }
        },
        INCREMENT(state,item){
            let found = state.cart.find(product => product.id == item.id);
            if (found) {
                found.quantity ++;
                found.total_price += found.sale_price;
                state.cartCount++;
            }
        },
        DECREMENT(state,item){
            let found = state.cart.find(product => product.id == item.id);
            if (found) {
                found.quantity --;
                found.total_price -= found.sale_price;
                state.cartCount--;
            }
        },

        SAVE_CART(state) {
            window.localStorage.setItem('storeCart', JSON.stringify(state.cart));
            window.localStorage.setItem('storeCartCount', state.cartCount);
        },

        REMOVE_CART(){
            window.localStorage.removeItem('storeCart');
            window.localStorage.removeItem('storeCartCount');
        }
    },
});
