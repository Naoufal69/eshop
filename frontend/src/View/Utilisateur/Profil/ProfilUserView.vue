<template>
  <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-2xl shadow-md">
    <div class="flex items-center space-x-4 mb-4">
      <img
        :src="profilePicture || 'https://via.placeholder.com/100'"
        alt="Photo de profil"
        class="w-20 h-20 rounded-full object-cover border"
      />
      <div>
        <h1 class="text-2xl font-semibold text-gray-800">
          Bonjour, {{ name }}
        </h1>
        <p class="text-sm text-gray-500">
          Date de naissance : {{ formattedBirthDate || "N/A" }} ({{ age }} ans)
        </p>
      </div>
    </div>

    <div class="space-y-4">
      <div class="flex items-center space-x-2">
        <i class="fa fa-envelope text-blue-600"></i>
        <span class="text-base text-gray-800">{{ email }}</span>
      </div>
      <div class="flex items-center space-x-2">
        <i class="fa fa-phone text-red-500"></i>
        <span class="text-base text-gray-800">{{ phone }}</span>
      </div>
    </div>
  </div>
  <div class="flex justify-center gap-4 mt-8">
    <button
      @click="showUpdateProfileModal = true"
      class="flex-1 max-w-[200px] bg-indigo-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-indigo-700 transition duration-200"
    >
      Modifier le profil
    </button>
    <button
      @click="showCommandesModal = true"
      class="flex-1 max-w-[200px] bg-gray-700 text-white font-semibold py-2 px-4 rounded-md hover:bg-gray-800 transition duration-200"
    >
      Afficher mes commandes
    </button>
  </div>

  <!-- Modal : Modifier le profil -->
  <div
    v-if="showUpdateProfileModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="showUpdateProfileModal = false"
  >
    <updateProfile @close="showUpdateProfileModal = false" />
  </div>

  <!-- Modal : Commandes utilisateur -->
  <div
    v-if="showCommandesModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="showCommandesModal = false"
  >
    <div class="bg-white rounded-xl p-6 max-w-3xl w-full shadow-lg">
      <commandesUtilisateur @close="showCommandesModal = false" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref, computed } from "vue";
import { useUserStore } from "../../../store/userStore";
import axios from "axios";

import updateProfile from "../../../components/Modal/Profil/updateProfile.vue";
import commandesUtilisateur from "../../../components/Modal/Profil/commandesUtilisateur.vue";

const name = ref("");
const email = ref("");
const phone = ref("");
const profilePicture = ref("");
const birthDate = ref("");
const age = ref(0);

const showUpdateProfileModal = ref(false);
const showCommandesModal = ref(false);

const userStore = useUserStore();
const urlProfile: string =
  import.meta.env.VITE_APP_API_URL + "users/profile/" + userStore.getUserId;

const formattedBirthDate = computed(() => {
  if (!birthDate.value) return null;
  const date = new Date(birthDate.value);
  return date.toLocaleDateString("fr-FR", {
    day: "2-digit",
    month: "2-digit",
    year: "2-digit",
  });
});

const calculateAge = (birthDate: string) => {
  const birth = new Date(birthDate);
  const today = new Date();
  let age = today.getFullYear() - birth.getFullYear();
  const m = today.getMonth() - birth.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) {
    age--;
  }
  return age;
};

onMounted(() => {
  axios
    .get(urlProfile, {
      headers: {
        Authorization: `Bearer ${userStore.getToken}`,
      },
    })
    .then((response) => {
      name.value = response.data.user.name;
      email.value = response.data.user.email;
      phone.value = response.data.user.phone;
      birthDate.value = response.data.user.birthDate;
      profilePicture.value = response.data.profile_picture;
      age.value = calculateAge(birthDate.value);
    })
    .catch((error) => {
      console.error("Erreur lors de la récupération du profil:", error);
    });
});
</script>
