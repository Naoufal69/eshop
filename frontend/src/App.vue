<template>
  <div class="flex flex-col items-center justify-center min-h-screen bg-white text-gray-800">
    <div class="flex gap-6 mb-8">
      <a href="https://vite.dev" target="_blank">
        <img
          src="/vite.svg"
          alt="Vite logo"
          class="h-24 p-6 transition duration-300 hover:drop-shadow-[0_0_2em_#646cffaa]"
        />
      </a>
      <a href="https://vuejs.org/" target="_blank">
        <img
          src="./assets/vue.svg"
          alt="Vue logo"
          class="h-24 p-6 transition duration-300 hover:drop-shadow-[0_0_2em_#42b883aa]"
        />
      </a>
    </div>

    <HelloWorld msg="Vite + Vue" />
  </div>
</template>

<script setup lang="ts">
import HelloWorld from './components/HelloWorld.vue'
</script>