<template>
  <header
    class="bg-black text-white py-4 px-6 flex items-center justify-between"
  >
    <div class="flex items-center gap-2 hidden md:flex">
      <img
        src="@/assets/vue.svg"
        alt="Logo"
        class="w-10 h-10 rounded-full object-cover border border-white"
      />
    </div>

    <div class="flex-1 max-w-md mx-4">
      <div
        class="flex items-center rounded-full px-4 py-2 transition-colors duration-200"
        :class="isFocused ? 'bg-white text-black' : 'bg-[#150248] text-white'"
      >
        <i
          class="fas fa-search mr-2 transition-colors duration-200"
          :class="isFocused ? 'text-black' : 'text-white'"
        ></i>
        <input
          type="text"
          placeholder="Rechercher..."
          class="bg-transparent focus:outline-none w-full"
          @focus="isFocused = true"
          @blur="isFocused = false"
        />
      </div>
    </div>

    <div class="w-10 h-10 flex items-center justify-center">
      <RouterLink :to="route">
        <i
          class="fas fa-user text-xl cursor-pointer hover:text-gray-300 transition-colors duration-150"
        ></i
      ></RouterLink>
    </div>
  </header>
</template>

<script setup lang="ts">
import { onMounted, ref } from "vue";
import { useUserStore } from "../../store/userStore";

const isFocused = ref(false);
const route = ref("");
const userStore = useUserStore();

onMounted(()=>{
  if (userStore.isAuthenticated) {
    if (userStore.isVendeur) {
      route.value = "/Vendeur/Profil/";
    } else if (userStore.isUtilisateur) {
      route.value = "/Utilisateur/Profil/";
    }else{
      route.value = "/Admin/Proil/";
    }
    route.value += userStore.getUserId;
  } else {
    route.value = "/Utilisateur/Connexion";
  }
})
</script>
