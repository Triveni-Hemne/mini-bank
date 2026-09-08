<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head } from '@inertiajs/vue3'
import { onMounted } from 'vue'
import Chart from 'chart.js/auto'

const props = defineProps({
  totalCustomers: Number,
  totalAccounts: Number,
  totalBalance: Number,
  todayTransactions: Number,
  transactionsChart: Array,
  accountTypes: Array
})

const formatCurrency = (amount) => {
  return new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: 'INR'
  }).format(amount)
}

onMounted(() => {

  // 📈 Line Chart (Transactions)
  new Chart(document.getElementById('transactionsChart'), {
    type: 'line',
    data: {
      labels: props.transactionsChart.map(i => i.date),
      datasets: [
        {
          label: 'Credit',
          data: props.transactionsChart.map(i => i.credit),
          borderColor: 'green'
        },
        {
          label: 'Debit',
          data: props.transactionsChart.map(i => i.debit),
          borderColor: 'red'
        }
      ]
    }
  })

  // 🥧 Pie Chart (Account Types)
  new Chart(document.getElementById('accountChart'), {
    type: 'pie',
    data: {
      labels: props.accountTypes.map(i => i.account_type),
      datasets: [{
        data: props.accountTypes.map(i => i.total)
      }]
    }
  })

})
</script>

<template>
  <AdminLayout>
    <Head title="Dashboard" />

    <div class="p-6 bg-gray-50 min-h-screen">

      <!-- Cards -->
      <div class="grid md:grid-cols-4 gap-6 mb-6">

        <div class="bg-white p-4 rounded-xl shadow-sm">
          <p class="text-gray-500 text-sm">Customers</p>
          <h3 class="text-lg font-bold">{{ totalCustomers }}</h3>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm">
          <p class="text-gray-500 text-sm">Accounts</p>
          <h3 class="text-lg font-bold">{{ totalAccounts }}</h3>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm">
          <p class="text-gray-500 text-sm">Total Balance</p>
          <h3 class="text-lg font-bold text-green-600">
            {{ formatCurrency(totalBalance) }}
          </h3>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm">
          <p class="text-gray-500 text-sm">Today's Transactions</p>
          <h3 class="text-lg font-bold">{{ todayTransactions }}</h3>
        </div>

      </div>

      <!-- Charts -->
      <div class="grid md:grid-cols-2 gap-6">

        <!-- Line Chart -->
        <div class="bg-white p-4 rounded-xl shadow-sm">
          <h3 class="mb-3 text-gray-700">Transactions Overview</h3>
          <canvas id="transactionsChart"></canvas>
        </div>

        <!-- Pie Chart -->
        <div class="bg-white p-4 rounded-xl shadow-sm">
          <h3 class="mb-3 text-gray-700">Account Types</h3>
          <canvas id="accountChart"></canvas>
        </div>

      </div>

    </div>
  </AdminLayout>
</template>