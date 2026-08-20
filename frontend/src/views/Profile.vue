<template>
  <section class="space-y-6">
    <div>
      <p class="text-sm font-semibold text-indigo-600">Account</p>
      <h2 class="text-2xl font-black">Profile</h2>
    </div>
    <Loader v-if="loading" />
    <div v-else class="grid gap-6 lg:grid-cols-2">
      <form
        class="rounded-2xl bg-white p-5 ring-1 ring-slate-200"
        @submit.prevent="updateProfileForm"
      >
        <h3 class="text-lg font-black">Personal details</h3>
        <div class="mt-5 space-y-4">
          <label class="block"
            ><span class="label">Name</span
            ><input v-model="profile.name" class="input" required /></label
          ><label class="block"
            ><span class="label">Email</span
            ><input v-model="profile.email" type="email" class="input" required
          /></label>
        </div>
        <button
          class="mt-5 rounded-xl bg-indigo-600 px-4 py-3 text-sm font-bold text-white"
          :disabled="updating"
        >
          {{ updating ? "Saving…" : "Save changes" }}
        </button>
        <p
          v-if="message"
          :class="success ? 'text-emerald-600' : 'text-red-600'"
          class="mt-3 text-sm font-semibold"
        >
          {{ message }}
        </p>
      </form>
      <form
        class="rounded-2xl bg-white p-5 ring-1 ring-slate-200"
        @submit.prevent="changePasswordForm"
      >
        <h3 class="text-lg font-black">Change password</h3>
        <div class="mt-5 space-y-4">
          <label class="block"
            ><span class="label">Current password</span
            ><input
              v-model="passwordData.current_password"
              type="password"
              class="input"
              required /></label
          ><label class="block"
            ><span class="label">New password</span
            ><input
              v-model="passwordData.new_password"
              type="password"
              class="input"
              minlength="8"
              required /></label
          ><label class="block"
            ><span class="label">Confirm new password</span
            ><input
              v-model="passwordData.new_password_confirmation"
              type="password"
              class="input"
              minlength="8"
              required
          /></label>
        </div>
        <button
          class="mt-5 rounded-xl bg-slate-900 px-4 py-3 text-sm font-bold text-white"
          :disabled="changingPassword"
        >
          {{ changingPassword ? "Changing…" : "Change password" }}
        </button>
        <p
          v-if="passwordMessage"
          :class="passwordSuccess ? 'text-emerald-600' : 'text-red-600'"
          class="mt-3 text-sm font-semibold"
        >
          {{ passwordMessage }}
        </p>
      </form>
      <div class="rounded-2xl bg-red-50 p-5 ring-1 ring-red-100 lg:col-span-2">
        <h3 class="font-black text-red-900">Danger zone</h3>
        <p class="mt-1 text-sm text-red-700">
          Deleting your account permanently removes your clients, invoices and
          payments.
        </p>
        <button
          class="mt-4 rounded-xl bg-red-600 px-4 py-3 text-sm font-bold text-white"
          @click="deleteAccountForm"
        >
          Delete account
        </button>
      </div>
    </div>
  </section>
</template>
<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "../stores/auth";
import {
  getProfile,
  updateProfile,
  changePassword,
  deleteAccount as deleteAccountApi,
} from "../services/profile";
import Loader from "../components/Loader.vue";
const authStore = useAuthStore();
const router = useRouter();
const loading = ref(true);
const updating = ref(false);
const changingPassword = ref(false);
const profile = ref({ name: "", email: "" });
const message = ref("");
const success = ref(false);
const passwordMessage = ref("");
const passwordSuccess = ref(false);
const passwordData = ref({
  current_password: "",
  new_password: "",
  new_password_confirmation: "",
});
async function loadProfile() {
  try {
    const response = await getProfile();
    const user = response.user || response;
    profile.value = { name: user.name || "", email: user.email || "" };
  } finally {
    loading.value = false;
  }
}
async function updateProfileForm() {
  updating.value = true;
  message.value = "";
  try {
    const response = await updateProfile(profile.value);
    const user = response.user || response;
    authStore.user = user;
    success.value = true;
    message.value = "Profile updated successfully.";
  } catch (e) {
    success.value = false;
    message.value = e.response?.data?.message || "Update failed.";
  } finally {
    updating.value = false;
  }
}
async function changePasswordForm() {
  changingPassword.value = true;
  passwordMessage.value = "";
  try {
    await changePassword(passwordData.value);
    passwordSuccess.value = true;
    passwordMessage.value = "Password changed successfully.";
    passwordData.value = {
      current_password: "",
      new_password: "",
      new_password_confirmation: "",
    };
  } catch (e) {
    passwordSuccess.value = false;
    passwordMessage.value =
      e.response?.data?.message || "Password change failed.";
  } finally {
    changingPassword.value = false;
  }
}
async function deleteAccountForm() {
  if (!window.confirm("Are you sure? This cannot be undone.")) return;
  await deleteAccountApi();
  authStore.user = null;
  router.push("/login");
}
onMounted(loadProfile);
</script>
<style scoped>
.label {
  @apply mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500;
}
.input {
  @apply w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10;
}
</style>
