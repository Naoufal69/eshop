import { createRouter, createWebHistory } from 'vue-router';
import type { RouteRecordRaw } from 'vue-router';

import HomeView from '../View/Home Page/HomeView.vue';
import ConnexionView from '../View/Connexion/ConnexionView.vue';
import InscriptionUtilisateursView from '../View/Inscription/Utilisateurs/InscriptionUtilisateursView.vue';
import InscriptionVendeursView from '../View/Inscription/Vendeurs/InscriptionVendeursView.vue';
import ProfilUserView from '../View/Utilisateur/Profil/ProfilUserView.vue';


const routes: RouteRecordRaw[] = [
    {
        path: '/',
        name: 'Home',
        component: HomeView,
    },
    {
      path: '/Utilisateur/Connexion',
      name: 'Connexion',
      component: ConnexionView,
    },
    {
      path: '/Utilisateur/Inscription',
      name: 'InscriptionUtilisateurs',
      component: InscriptionUtilisateursView,
    },
    {
      path: '/Vendeur/Inscription',
      name: 'InscriptionVendeurs',
      component: InscriptionVendeursView,
    },
    {
      path: '/Utilisateur/Profil/:id',
      name: 'Profil',
      component: ProfilUserView,
    },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
