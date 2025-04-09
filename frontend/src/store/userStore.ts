import { defineStore } from 'pinia';

interface User {
  id: number | null;
  name: string;
  mail: string;
  profileType: string;
  token: string;
  tokenCreatedAt: string | null; // ISO date
}

interface CartItem {
  id: number;
  quantity: number;
}

export const useUserStore = defineStore('user', {
  state: (): { user: User; cart: CartItem[] } => ({
    user: {
      id: null,
      name: '',
      mail: '',
      profileType: '',
      token: '',
      tokenCreatedAt: null,
    },
    cart: [],
  }),

  persist: true,

  getters: {
    isAuthenticated: (state): boolean => {
      return !!state.user.token;
    },
  },

  actions: {
    setUser(userData: Omit<User, 'tokenCreatedAt'> & { token: string }) {
      this.user = {
        ...userData,
        tokenCreatedAt: new Date().toISOString(),
      };
    },
    logout() {
      this.user = {
        id: null,
        name: '',
        mail: '',
        profileType: '',
        token: '',
        tokenCreatedAt: null,
      };
      this.cart = [];
    },
    addToCart(product: CartItem) {
      const index = this.cart.findIndex((item) => item.id === product.id);
      if (index !== -1) {
        this.cart[index].quantity += product.quantity;
      } else {
        this.cart.push(product);
      }
    },
    removeFromCart(productId: number) {
      this.cart = this.cart.filter((item) => item.id !== productId);
    },
    clearCart() {
      this.cart = [];
    },
  },
});
