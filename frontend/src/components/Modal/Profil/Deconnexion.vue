<template>
  <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md text-center">
    <h2 class="text-xl font-bold mb-4">Déconnexion</h2>
    <p class="mb-6">Voulez-vous vraiment vous déconnecter ?</p>
    <div class="flex justify-center gap-4">
      <button @click="$emit('close')" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">
        Annuler
      </button>
      <button @click="$emit('logout')" class="px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600">
        Se déconnecter
      </button>
    </div>
  </div>
</template>
