<template>
  <div class="min-h-screen flex flex-col">
    <HeaderView />
    <main class="flex-1">
      <router-view />
    </main>
    <FooterView />
  </div>
</template>

<script setup lang="ts">
import HeaderView from "./View/Home Page/HeaderView.vue";
import FooterView from "./View/Home Page/FooterView.vue";
</script>
