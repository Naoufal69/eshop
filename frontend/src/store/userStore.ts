import { defineStore } from "pinia";

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

export const useUserStore = defineStore("user", {
  state: (): { user: User; cart: CartItem[] } => ({
    user: {
      id: null,
      name: "",
      mail: "",
      profileType: "",
      token: "",
      tokenCreatedAt: null,
    },
    cart: [],
  }),

  persist: true,

  getters: {
    isAuthenticated: (state): boolean => {
      return !!state.user.token;
    },
    isUtilisateur: (state): boolean => {
      return state.user.profileType === "user";
    },
    isAdmin: (state): boolean => {
      return state.user.profileType === "admin";
    },
    isVendeur: (state): boolean => {
      return state.user.profileType === "seller";
    },
    getUserId(state): number | null {
      return state.user.id;
    },
    getProfileType(state): string {
      return state.user.profileType;
    },
    getToken(state): string {
      return state.user.token;
    },
    getUserEmail(state): string {
      return state.user.mail;
    },
    getUserName(state): string {
      return state.user.name;
    },
  },

  actions: {
    setUser(userData: Omit<User, "tokenCreatedAt"> & { token: string }) {
      this.user = {
        ...userData,
        tokenCreatedAt: new Date().toISOString(),
      };
    },
    toString(): void {
      console.log(`Nom : ${this.user.name}, Mail : ${this.user.mail}, ID : ${this.user.id}, Type de profil : ${this.user.profileType}`);
    },
    logout() {
      this.user = {
        id: null,
        name: "",
        mail: "",
        profileType: "",
        token: "",
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
