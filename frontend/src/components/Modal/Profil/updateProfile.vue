<template>
  <div
    class="relative w-full sm:w-[50%] md:w-[80%] lg:w-[60%] xl:w-[50%] max-w-4xl bg-white rounded-xl shadow-lg p-6"
  >
    <button
      @click="$emit('close')"
      class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-xl"
      aria-label="Fermer"
    >
      &times;
    </button>
    <updateUser />
  </div>
</template>

<script setup lang="ts">
import updateUser from "../../Profil/updateUser.vue";
</script>
