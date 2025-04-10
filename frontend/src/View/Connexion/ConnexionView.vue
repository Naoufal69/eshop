<template>
  <div
    class="flex flex-col items-center justify-center min-h-[90vh] bg-gray-100"
  >
    <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-sm">
      <h2 class="text-2xl font-bold mb-4 text-center">Connexion</h2>
      <form @submit.prevent="handleSubmit">
        <div class="mb-3">
          <label for="email" class="block text-sm font-medium text-gray-700"
            >Email</label
          >
          <input
            type="email"
            id="email"
            v-model="email"
            required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700"
            >Mot de passe</label
          >
          <input
            type="password"
            id="password"
            v-model="password"
            required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <button
          type="submit"
          class="w-full bg-[#150248] text-white py-2 rounded-md hover:bg-[#4a0cee] transition duration-200"
        >
          Se connecter
        </button>
      </form>

      <p class="mt-4 text-center text-sm text-gray-600">
        Pas encore inscrit ?
        <RouterLink
          to="/Utilisateur/Inscription"
          class="text-[#150248] hover:underline"
        >
          Créer un compte
        </RouterLink>
      </p>

      <p class="mt-2 text-center text-sm text-gray-600">
        Créer un compte vendeur ?
        <RouterLink
          to="/Vendeur/Inscription"
          class="text-[#150248] hover:underline"
        >
          C'est par là
        </RouterLink>
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
const email: string = "";
const password: string = "";

const handleSubmit = () => {
  console.log("Email:", email);
  console.log("Password:", password);
};
</script>
