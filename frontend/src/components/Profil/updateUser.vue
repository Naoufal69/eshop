<template>
  <div
    class="flex flex-col items-center justify-center w-full px-4 py-8 sm:px-6 md:px-10"
  >
    <button @click="profileUpdate = true ; passwordUpdate = false" class="absolute top-10 right-4 text-gray-500 hover:text-gray-800 text-xl" >
        Profile
    </button>
    <button @click="profileUpdate = false ; passwordUpdate = true" class="absolute top-10 left-4 text-gray-500 hover:text-gray-800 text-xl" >
        Password
    </button>
    <div v-if="profileUpdate">
      <profile/>
    </div>
    <div v-if="passwordUpdate">
      <h2 class="text-2xl font-bold mb-4">Modifier le mot de passe</h2>
      <password/>
    </div>
  </div>
</template>

<script setup lang="ts">

const profileUpdate = ref(true);
const passwordUpdate = ref(false);

import profile from "./Sous-Component/profile.vue";
import password from "./Sous-Component/password.vue";
import { ref } from "vue";
</script>
