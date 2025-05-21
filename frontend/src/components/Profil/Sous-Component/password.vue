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

const currentPassword = ref('');
const newPassword = ref('');
const confirmPassword = ref('');

const handlePasswordUpdate = async () => {
  if (newPassword.value !== confirmPassword.value) {
    alert("Les mots de passe ne correspondent pas.");
    return;
  }

  console.log('Mise à jour du mot de passe avec :', {
    current: currentPassword.value,
    new: newPassword.value,
    confirm: confirmPassword.value,
  });

};
</script>
