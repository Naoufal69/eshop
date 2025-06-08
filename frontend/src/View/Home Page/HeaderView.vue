<template>
  <header class="bg-black text-white py-3 px-4 flex items-center justify-between">
    <div class="flex items-center gap-2 hidden md:flex">
      <RouterLink to="/">
        <img
          src="@/assets/vue.svg"
          alt="Logo"
          class="w-9 h-9 rounded-full object-cover border border-white"
        />
      </RouterLink>
    </div>
    <div class="flex-1 max-w-xs sm:max-w-sm md:max-w-md mx-2 sm:mx-4">
      <div
        class="flex items-center rounded-full px-3 py-2 transition-colors duration-200"
        :class="isFocused ? 'bg-white text-black' : 'bg-[#150248] text-white'"
      >
        <i
          class="fas fa-search mr-2 transition-colors duration-200"
          :class="isFocused ? 'text-black' : 'text-white'"
        ></i>
        <input
          type="text"
          placeholder="Rechercher..."
          class="bg-transparent focus:outline-none w-full text-sm"
          @focus="isFocused = true"
          @blur="isFocused = false"
        />
      </div>
    </div>
    <div class="relative flex items-center" style="margin-right: max(12px, 80px);">
      <div
        @mouseenter="onEnter"
        @mouseleave="onLeave"
        class="flex flex-col items-center"
        style="position: relative;"
      >
        <RouterLink :to="route" class="w-9 h-9 flex items-center justify-center z-50">
          <i class="fas fa-user text-xl cursor-pointer hover:text-gray-300 transition-colors duration-150"></i>
        </RouterLink>
        <div
          v-if="showMenu && userStore.isAuthenticated"
          class="pointer-events-auto"
          style="position: absolute; left: 50%; top: 36px; transform: translateX(-50%); height: 14px; width: 60px; z-index: 40;"
        ></div>
        <div
          v-if="showMenu && userStore.isAuthenticated"
          class="absolute left-1/2 top-[50px] min-w-[140px] max-w-xs bg-white text-black rounded-lg shadow-lg py-2 z-50 border border-gray-200 -translate-x-1/2"
          style="width: max-content"
          @mouseenter="showMenu = true"
          @mouseleave="showMenu = false"
        >
          <button
            @click="onDeconnexion"
            class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-sm"
          >
            Déconnexion
          </button>
        </div>
      </div>
    </div>
  </header>

  <div
    v-if="showDeconnexionModal"
    class="fixed inset-0 z-[60] flex items-center justify-center"
  >
    <div
      class="absolute inset-0 bg-black bg-opacity-40"
      @click="closeDeconnexionModal"
    ></div>
    <div class="relative z-10" @click.stop>
      <Deconnexion @close="closeDeconnexionModal" @logout="handleLogout" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from "vue";
import { useUserStore } from "../../store/userStore";
import Deconnexion from "../../components/Modal/Profil/Deconnexion.vue";
import router from "../../router";

const isFocused = ref(false);
const route = ref("");
const userStore = useUserStore();
const showMenu = ref(false);
const showDeconnexionModal = ref(false);

function onEnter() {
  showMenu.value = true;
}
function onLeave() {
  showMenu.value = false;
}

function updateRouteForUser() {
  if (userStore.isAuthenticated) {
    if (userStore.isVendeur) {
      route.value = "/Vendeur/Profil/";
    } else if (userStore.isUtilisateur) {
      route.value = "/Utilisateur/Profil/";
    } else {
      route.value = "/Admin/Proil/";
    }
    route.value += userStore.getUserId;
  } else {
    route.value = "/Utilisateur/Connexion";
  }
}

onMounted(updateRouteForUser);

function closeDeconnexionModal() {
  showDeconnexionModal.value = false;
}

function onDeconnexion() {
  showDeconnexionModal.value = true;
  showMenu.value = false;
}

function handleLogout() {
  userStore.logout();
  closeDeconnexionModal();
  updateRouteForUser();
  router.push('/');
}
</script>
