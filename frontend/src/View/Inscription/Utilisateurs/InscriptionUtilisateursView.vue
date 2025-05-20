<template>
  <div
    class="flex flex-col items-center justify-center min-h-screen bg-gray-100"
  >
    <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-sm">
      <h2 class="text-2xl font-bold mb-6 text-center">Inscription</h2>
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
                majuscule, une minuscule, un chiffre et un caractère spécial.
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

          <div class="h-2 w-full mt-2 bg-gray-200 rounded-full overflow-hidden">
            <div
              class="h-full transition-all duration-300"
              :class="passwordStrength.color"
              :style="{ width: passwordStrength.width }"
            ></div>
          </div>

          <p class="text-xs mt-1 text-gray-600">{{ passwordStrength.label }}</p>
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
          <label for="birthdate" class="block text-sm font-medium text-gray-700"
            >Date de naissance</label
          >
          <input
            type="date"
            id="birthdate"
            v-model="birthdate"
            required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <div class="mb-4">
          <label
            for="photo"
            class="block text-sm font-medium text-gray-700 mb-1"
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

      <p class="mt-4 text-center text-sm text-gray-600">
        Créer un compte vendeur ?
        <RouterLink
          to="/Vendeur/Inscription"
          class="text-[#150248] hover:underline"
          >C'est par là</RouterLink
        >
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from "vue";
import axios from "axios";

const email = ref("");
const password = ref("");
const passwordConfirmation = ref("");
const name = ref("");
const phone = ref("");
const birthdate = ref("");
const photo = ref<File | null>(null);
const photoPreview = ref<string | null>(null);
const apiUrl = import.meta.env.VITE_APP_API_URL;

const passwordStrength = computed(() => {
  const pwd: string = password.value;
  let score: number = 0;

  const length = pwd.length;

  const hasLower = /[a-z]/.test(pwd);
  const hasUpper = /[A-Z]/.test(pwd);
  const hasDigit = /\d/.test(pwd);
  const hasSpecial = /[\W_]/.test(pwd);
  const isOnlyOneChar = /^([a-zA-Z0-9])\1*$/.test(pwd);

  if (length >= 8) score++;
  if (length >= 12) score++;
  if (hasLower) score++;
  if (hasUpper) score++;
  if (hasDigit) score++;
  if (hasSpecial) score++;

  if (length < 6) score -= 3;
  if (isOnlyOneChar) score -= 2;

  const clamp = (val: number, min: number, max: number) =>
    Math.max(min, Math.min(max, val));
  const finalScore = clamp(score, 0, 6);

  switch (finalScore) {
    case 0:
      return { score: finalScore, label: "Très faible", width: "0%", color: "bg-red-500" };
    case 1:
      return { score: finalScore, label: "Faible", width: "20%", color: "bg-orange-500" };
    case 2:
      return { score: finalScore, label: "Moyen", width: "40%", color: "bg-yellow-400" };
    case 3:
      return { score: finalScore, label: "Acceptable", width: "60%", color: "bg-lime-400" };
    case 4:
      return { score: finalScore, label: "Bon", width: "80%", color: "bg-green-400" };
    case 5:
    case 6:
      return { score: finalScore, label: "Excellent", width: "100%", color: "bg-green-500" };
    default:
      return { score: finalScore, label: "", width: "0%", color: "" };
  }
});

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

const checkIfPasswordsMatch = (): boolean => {
  if (password.value !== passwordConfirmation.value) {
    alert("Les mots de passe ne correspondent pas.");
    return false;
  }else{
    return true;
  }
}

const isPasswordStrongEnough = (score: number): boolean => {
  if (score < 3) {
    return false;
  }else{
    return true;
  }
}

const handleSubmit = () => {
  if (!isPasswordStrongEnough(passwordStrength.value.score)) {
    alert("Le mot de passe n'est pas assez fort.");
    return;
  }

  if (!checkIfPasswordsMatch()) {
    alert("Les mots de passe ne correspondent pas.");
    return;
  }

  const formData = new FormData();
  formData.append("email", email.value);
  formData.append("password", password.value);
  formData.append("password_confirmation", passwordConfirmation.value);
  formData.append("name", name.value);
  formData.append("phone", phone.value);
  formData.append("birthdate", birthdate.value);
  if (photo.value) {
    formData.append("profile_picture", photo.value);
  }
  formData.append("profile_id", "1");

  axios.post(apiUrl + "users/register", formData, {
    headers: {
        "Content-Type": "application/json",
    },
    withCredentials: true,
  })
  .then((response) => {
    console.log(response.data);
  })
  .catch((error) => {
    console.error("Erreur lors de l'inscription :", error);
  });
  

};
</script>
