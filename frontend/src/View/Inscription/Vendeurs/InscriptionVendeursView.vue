<template>
  <div
    class="flex flex-col items-center justify-center min-h-screen bg-gray-100"
  >
    <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-sm">
      <h2 class="text-2xl font-bold mb-6 text-center">Inscription Vendeur</h2>
      <form @submit.prevent="handleSubmit">
        <div class="mb-4">
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
          <label
            for="password"
            class="block text-sm font-medium text-gray-700 flex items-center"
          >
            Mot de passe
            <div class="relative ml-2 group">
              <i
                class="fa-solid fa-circle-info text-gray-400 cursor-pointer"
              ></i>
              <div
                class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 w-64 text-xs bg-black text-white rounded px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-10 text-center"
              >
                Le mot de passe doit contenir au moins 8 caractères, une
                majuscule, une minuscule et un chiffre.
              </div>
            </div>
          </label>

          <input
            type="password"
            id="password"
            v-model="password"
            required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700"
            >Confirmez le mot de passe</label
          >
          <input
            type="password"
            id="passwordConfirmation"
            v-model="passwordConfirmation"
            required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <div class="mb-4">
          <label for="name" class="block text-sm font-medium text-gray-700"
            >Nom</label
          >
          <input
            type="text"
            id="name"
            v-model="name"
            required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <div class="mb-4">
          <label for="phone" class="block text-sm font-medium text-gray-700"
            >Téléphone</label
          >
          <input
            type="tel"
            id="phone"
            v-model="phone"
            required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <div class="mb-4">
          <label for="address" class="block text-sm font-medium text-gray-700"
            >Adresse</label
          >
          <input
            type="text"
            id="address"
            v-model="address"
            required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <div class="mb-4">
          <label for="logo" class="block text-sm font-medium text-gray-700 mb-1"
            >Logo</label
          >
          <div class="flex items-center gap-4">
            <input
              type="file"
              id="logo"
              @change="handleLogo"
              accept="image/*"
              class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
            />
            <div v-if="logoPreview" class="shrink-0">
              <img
                :src="logoPreview"
                alt="Logo"
                class="w-16 h-16 object-cover rounded-full border border-gray-300"
              />
            </div>
          </div>
        </div>

        <button
          type="submit"
          class="w-full bg-[#150248] text-white py-2 rounded-md hover:bg-[#4a0cee] transition duration-200"
        >
          S'inscrire
        </button>
      </form>

      <p class="mt-4 text-center text-sm text-gray-600">
        Déjà inscrit ?
        <RouterLink
          to="/Utilisateur/Connexion"
          class="text-[#150248] hover:underline"
          >Se connecter</RouterLink
        >
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";

const email = ref("");
const password = ref("");
const passwordConfirmation = ref("");
const name = ref("");
const phone = ref("");
const address = ref("");
const logo = ref<File | null>(null);
const logoPreview = ref<string | null>(null);

const handleLogo = (event: Event) => {
  const target = event.target as HTMLInputElement;
  const file = target.files?.[0] || null;
  logo.value = file;

  if (file) {
    logoPreview.value = URL.createObjectURL(file);
  } else {
    logoPreview.value = null;
  }
};

const handleSubmit = () => {
  console.log("Email:", email.value);
  console.log("Password:", password.value);
  console.log("passwordConfirmation:", passwordConfirmation.value);
  console.log("Nom:", name.value);
  console.log("Téléphone:", phone.value);
  console.log("Adresse:", address.value);
  console.log("Logo:", logo.value?.name);
};
</script>
