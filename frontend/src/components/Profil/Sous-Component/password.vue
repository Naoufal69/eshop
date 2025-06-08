<template>
  <div class="w-full px-4 py-4">
    <h1 class="text-2xl md:text-3xl font-bold mb-6 text-center">Modifier le mot de passe</h1>

    <form
      @submit.prevent="handlePasswordUpdate"
      class="mx-auto w-full sm:w-[90%] md:w-[80%] lg:w-[70%] xl:w-[50%] max-w-2xl bg-white p-6 rounded-lg shadow"
    >
      <div class="mb-4">
        <label for="currentPassword" class="block text-gray-700 text-sm font-bold mb-2">
          Mot de passe actuel
        </label>
        <input
          v-model="currentPassword"
          type="password"
          id="currentPassword"
          required
          class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div class="mb-4">
        <label for="newPassword" class="block text-gray-700 text-sm font-bold mb-2">
          Nouveau mot de passe
        </label>
        <input
          v-model="newPassword"
          type="password"
          id="newPassword"
          required
          class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div class="mb-6">
        <label for="confirmPassword" class="block text-gray-700 text-sm font-bold mb-2">
          Confirmer le nouveau mot de passe
        </label>
        <input
          v-model="confirmPassword"
          type="password"
          id="confirmPassword"
          required
          class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <button
        type="submit"
        class="bg-[#150248] hover:bg-[#4a0cee] text-white font-bold py-2 px-4 rounded w-full transition"
      >
        Mettre à jour le mot de passe
      </button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useUserStore } from "../../../store/userStore";
import axios from 'axios';
import router from '../../../router';
const userStore = useUserStore();

const currentPassword = ref('');
const newPassword = ref('');
const confirmPassword = ref('');
const urlUpdateProfile = import.meta.env.VITE_URL_UPDATE_PROFILE + userStore.getUserId + '/password';

const handlePasswordUpdate = async () => {
  // if (newPassword.value !== confirmPassword.value) {
  //   alert("Les mots de passe ne correspondent pas.");
  //   return;
  // }

  const data = {
    currentPassword: currentPassword.value,
    newPassword: newPassword.value,
    confirmPassword: confirmPassword.value
  };
  console.log(import.meta.env.VITE_APP_API_URL + userStore.getUserId + '/password');
  userStore.toString();

  // axios.post(urlUpdateProfile, data, {
  //   headers: {
  //     'Authorization': `Bearer ${userStore.getToken}`
  //   }
  // })
  // .then(response => {
  //   if (response.status === 200) {
  //     router.push('/Utilisateur/Profil/'+userStore.getUserId);
  //   }
  // })

};
</script>
