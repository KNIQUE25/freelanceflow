<template>
  <section>
    <div class="mb-6">
      <p class="text-sm font-semibold text-indigo-600">Insights</p>
      <h2 class="text-2xl font-black">Reports</h2>
      <p class="mt-1 text-sm text-slate-500">
        Understand revenue, invoice status, clients and payment methods.
      </p>
    </div>
    <div class="grid gap-5 lg:grid-cols-2">
      <article class="card">
        <div class="flex items-center justify-between">
          <h3 class="card-title">Revenue</h3>
          <select v-model="period" class="input w-auto">
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
            <option value="yearly">Yearly</option>
          </select>
        </div>
        <Loader v-if="revenueLoading" />
        <div v-else class="mt-4 space-y-2">
          <div
            v-for="item in revenueData"
            :key="item.period"
            class="flex justify-between rounded-xl bg-slate-50 p-3 text-sm"
          >
            <span>{{ item.period }}</span
            ><strong>KES {{ money(item.revenue) }}</strong>
          </div>
          <p v-if="!revenueData.length" class="text-sm text-slate-400">
            No paid invoice data yet.
          </p>
        </div>
      </article>
      <article class="card">
        <h3 class="card-title">Invoice status</h3>
        <Loader v-if="statusLoading" />
        <div v-else class="mt-4 space-y-2">
          <div
            v-for="item in statusData"
            :key="item.status"
            class="flex justify-between rounded-xl bg-slate-50 p-3 text-sm"
          >
            <span>{{ pretty(item.status) }}</span
            ><strong>{{ item.count }} · KES {{ money(item.total) }}</strong>
          </div>
        </div>
      </article>
      <article class="card">
        <h3 class="card-title">Client summary</h3>
        <Loader v-if="clientLoading" />
        <div v-else class="mt-4 space-y-2">
          <div
            v-for="client in clientData"
            :key="client.id"
            class="flex justify-between gap-4 rounded-xl bg-slate-50 p-3 text-sm"
          >
            <span class="font-semibold">{{ client.name }}</span
            ><span
              >{{ client.invoice_count }} invoices · KES
              {{ money(client.total_invoice_value) }}</span
            >
          </div>
        </div>
      </article>
      <article class="card">
        <h3 class="card-title">Payment methods</h3>
        <Loader v-if="paymentLoading" />
        <div v-else class="mt-4 space-y-2">
          <div
            v-for="item in paymentData"
            :key="item.method"
            class="flex justify-between rounded-xl bg-slate-50 p-3 text-sm"
          >
            <span class="font-semibold">{{ pretty(item.method) }}</span
            ><span>{{ item.count }} · KES {{ money(item.total) }}</span>
          </div>
        </div>
      </article>
    </div>
  </section>
</template>
<script setup>
import { onMounted, ref, watch } from "vue";
import {
  getRevenue,
  getInvoiceStatus,
  getClientSummary,
  getPaymentMethods,
} from "../services/reports";
import Loader from "../components/Loader.vue";
const period = ref("monthly");
const revenueData = ref([]);
const statusData = ref([]);
const clientData = ref([]);
const paymentData = ref([]);
const revenueLoading = ref(true);
const statusLoading = ref(true);
const clientLoading = ref(true);
const paymentLoading = ref(true);
const money = (v) =>
  Number(v || 0).toLocaleString("en-KE", {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  });
const pretty = (v) => String(v || "").replaceAll("_", " ");
async function loadRevenue() {
  revenueLoading.value = true;
  try {
    revenueData.value = await getRevenue({ period: period.value });
  } finally {
    revenueLoading.value = false;
  }
}
async function loadStatus() {
  statusLoading.value = true;
  try {
    statusData.value = await getInvoiceStatus();
  } finally {
    statusLoading.value = false;
  }
}
async function loadClients() {
  clientLoading.value = true;
  try {
    clientData.value = await getClientSummary();
  } finally {
    clientLoading.value = false;
  }
}
async function loadPayments() {
  paymentLoading.value = true;
  try {
    paymentData.value = await getPaymentMethods();
  } finally {
    paymentLoading.value = false;
  }
}
watch(period, loadRevenue);
onMounted(() => {
  loadRevenue();
  loadStatus();
  loadClients();
  loadPayments();
});
</script>
<style scoped>
.card {
  @apply rounded-2xl border border-slate-200 bg-white p-5 shadow-sm;
}
.card-title {
  @apply text-lg font-black text-slate-900;
}
.input {
  @apply rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500;
}
</style>
