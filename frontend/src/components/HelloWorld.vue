<template>
  <div class="text-center space-y-6">
    <h1 class="text-3xl font-bold text-indigo-600">{{ msg }}</h1>

    <div class="card space-y-4">
      <button
        type="button"
        @click="count++"
        class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded shadow transition"
      >
        count is {{ count }}
      </button>

      <p class="text-gray-600">
        Edit <code class="bg-gray-100 px-1 py-0.5 rounded">components/HelloWorld.vue</code> to test HMR
      </p>
    </div>

    <p>
      Check out
      <a
        href="https://vuejs.org/guide/quick-start.html#local"
        class="text-blue-600 hover:underline"
        target="_blank"
        >create-vue</a
      >, the official Vue + Vite starter
    </p>

    <p>
      Learn more about IDE Support for Vue in the
      <a
        href="https://vuejs.org/guide/scaling-up/tooling.html#ide-support"
        class="text-blue-600 hover:underline"
        target="_blank"
        >Vue Docs Scaling up Guide</a
      >.
    </p>

    <p class="text-gray-500 italic">Click on the Vite and Vue logos to learn more</p>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

defineProps<{ msg: string }>()

const count = ref(0)
</script>