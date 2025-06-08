<template>
  <div class="w-full px-4 py-4">
    <h1 class="text-2xl md:text-3xl font-bold mb-6 text-center">
      Mettre à jour votre profil
    </h1>
    <form
      @submit.prevent="handleUpdateProfile"
      class="mx-auto w-full sm:w-[90%] md:w-[80%] lg:w-[70%] xl:w-[60%] max-w-3xl bg-white p-6 rounded-lg shadow"
    >
      <div class="mb-4">
        <label for="name" class="block text-gray-700 text-sm font-bold mb-2"
          >Nom</label
        >
        <input
          v-model="name"
          type="text"
          id="name"
          class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div class="mb-4">
        <label for="email" class="block text-gray-700 text-sm font-bold mb-2"
          >Email</label
        >
        <input
          v-model="email"
          type="email"
          id="email"
          class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div class="mb-4">
        <label for="phone" class="block text-gray-700 text-sm font-bold mb-2"
          >Téléphone</label
        >
        <input
          v-model="phone"
          type="tel"
          id="phone"
          class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div class="mb-6">
        <label
          for="birthDate"
          class="block text-gray-700 text-sm font-bold mb-2"
          >Date de naissance</label
        >
        <input
          v-model="birthDate"
          type="date"
          id="birthDate"
          class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div class="mb-4">
        <label for="photo" class="block text-sm font-medium text-gray-700 mb-1"
          >Photo de profil</label
        >
        <div class="flex items-center gap-4">
          <input
            type="file"
            id="photo"
            @change="handlePhoto"
            accept="image/*"
            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
          />

          <div v-if="photoPreview" class="shrink-0">
            <img
              :src="photoPreview"
              alt="Aperçu"
              class="w-16 h-16 object-cover rounded-full border border-gray-300"
            />
          </div>
        </div>
      </div>

      <div class="mb-4">
        <label for="password" class="block text-gray-700 text-sm font-bold mb-2"
          >Mot de passe</label
        >
        <input
          v-model="password"
          type="password"
          id="password"
          required
          class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <button
        type="submit"
        class="bg-[#150248] hover:bg-[#4a0cee] text-white font-bold py-2 px-4 rounded w-full transition"
      >
        Mettre à jour le profil
      </button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { useUserStore } from "../../../store/userStore";
import axios from "axios";

const userStore = useUserStore();

const name = ref("");
const email = ref("");
const phone = ref("");
const birthDate = ref("");
const password = ref("");
const photo = ref<File | null>(null);
const photoPreview = ref<string | null>(null);
const urlUpdateProfile = import.meta.env.VITE_APP_API_URL + "users/profile/" + userStore.getUserId;


const handlePhoto = (event: Event) => {
  const target = event.target as HTMLInputElement;
  const file = target.files?.[0] || null;
  photo.value = file;

  if (file) {
    photoPreview.value = URL.createObjectURL(file);
  } else {
    photoPreview.value = null;
  }
};

const handleUpdateProfile = async () => {
  const formData = new FormData();
  if (photo.value) {
    formData.append("photo", photo.value);
  }
  if (name.value) {
    formData.append("name", name.value);
  }
  if (email.value) {
    formData.append("email", email.value);
  }
  formData.append("verifyEmail", userStore.getUserEmail);
  if (phone.value) {
    formData.append("phone", phone.value);
  }
  if (birthDate.value) {
    formData.append("birthDate", birthDate.value);
  }
  formData.append("password", password.value);

  axios.post(urlUpdateProfile, formData, {
    headers: {
      "Authorization": `Bearer ${userStore.getToken}`,
    },
  })
  .then((response) => {
    if (response.status === 200) {
      const token = userStore.getToken;
      userStore.logout();
      userStore.setUser({
          id: response.data.user.id,
          name: response.data.user.name,
          mail: response.data.user.email,
          profileType: response.data.user.profileType,
          token: token,
        });
    }
  })

};
</script>
