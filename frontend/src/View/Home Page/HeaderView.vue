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
        class="flex items-center bg-[#150248] text-white rounded-full px-4 py-2 transition-colors duration-200"
        :class="{
          'bg-white text-black': isFocused,
        }"
      >
        <i class="fas fa-search mr-2"></i>
        <input
          type="text"
          placeholder="Rechercher..."
          class="bg-transparent focus:outline-none w-full placeholder-white"
          @focus="isFocused = true"
          @blur="isFocused = false"
        />
      </div>
    </div>

    <div class="w-10 h-10 flex items-center justify-center">
      <i
        class="fas fa-user text-xl cursor-pointer hover:text-gray-300 transition-colors duration-150"
      ></i>
    </div>
  </header>
</template>

<script setup lang="ts">
import { ref } from "vue";

const isFocused = ref(false);
</script>
