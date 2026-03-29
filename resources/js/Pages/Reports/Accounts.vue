<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { reactive } from 'vue'

const props = defineProps({
  accounts: Object,
  totalAccounts: Number,
  totalBalance: Number,
  filters: Object
})

const localFilters = reactive({
  search: props.filters?.search || '',
  type: props.filters?.type || '',
  status: props.filters?.status || ''
})

const filter = () => {
  router.get('/admin/reports/accounts', localFilters, {
    preserveState: true,
    replace: true,
    preserveScroll: true
  })
}

// 💰 Currency formatter
const formatCurrency = (amount) => {
  return new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: 'INR'
  }).format(amount)
}
</script>

<template>
  <AdminLayout>
    <Head title="Account Reports" />

    <div class="p-6 bg-gray-50 min-h-screen">

      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">
          Account Report
        </h2>
      </div>

      <!-- Filters -->
      <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <form @submit.prevent="filter" class="grid md:grid-cols-4 gap-4">

          <div>
            <label class="text-sm text-gray-500">Search</label>
            <input v-model="localFilters.search"
              placeholder="Account Number"
              class="w-full mt-1 border rounded-lg px-3 py-2 text-sm" />
          </div>

          <div>
            <label class="text-sm text-gray-500">Account Type</label>
            <select v-model="localFilters.type"
              class="w-full mt-1 border rounded-lg px-3 py-2 text-sm">
              <option value="">All</option>
              <option value="saving">Saving</option>
              <option value="loan">Loan</option>
              <option value="current">Current</option>
            </select>
          </div>

          <div>
            <label class="text-sm text-gray-500">Status</label>
            <select v-model="localFilters.status"
              class="w-full mt-1 border rounded-lg px-3 py-2 text-sm">
              <option value="">All</option>
              <option value="active">Active</option>
              <option value="closed">Closed</option>
            </select>
          </div>

          <div class="flex items-end">
            <button class="w-full bg-black text-white rounded-lg py-2 text-sm">
              Apply
            </button>
          </div>

        </form>
      </div>

      <!-- Summary -->
      <div class="grid md:grid-cols-2 gap-6 mb-6">

        <div class="bg-white p-4 rounded-xl shadow-sm flex justify-between">
          <div>
            <p class="text-gray-500 text-sm">Total Accounts</p>
            <h3 class="text-lg font-bold text-blue-600">
              {{ totalAccounts }}
            </h3>
          </div>
          <div class="bg-blue-100 text-blue-600 p-3 rounded-full">🏦</div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm flex justify-between">
          <div>
            <p class="text-gray-500 text-sm">Total Balance</p>
            <h3 class="text-lg font-bold text-green-600">
              {{ formatCurrency(totalBalance) }}
            </h3>
          </div>
          <div class="bg-green-100 text-green-600 p-3 rounded-full">₹</div>
        </div>

      </div>

      <!-- Table -->
      <div class="bg-white rounded-xl shadow-sm">

        <div class="p-4 border-b flex justify-between">
          <h3 class="font-medium text-gray-700">Accounts</h3>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
              <tr>
                <th class="p-3 text-left">Account No</th>
                <th class="p-3 text-left">Customer</th>
                <th class="p-3 text-left">Type</th>
                <th class="p-3 text-right">Balance</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-left">Created</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="acc in accounts.data" :key="acc.id"
                  class="border-b hover:bg-gray-50">

                <td class="p-3 font-medium">
                  {{ acc.account_number }}
                </td>

                <td class="p-3">
                  {{ acc.user?.name }}
                </td>

                <td class="p-3 capitalize">
                  {{ acc.account_type }}
                </td>

                <td class="p-3 text-right font-semibold text-green-600">
                  {{ formatCurrency(acc.balance) }}
                </td>

                <td class="p-3">
                  <span
                    :class="acc.status === 'active'
                      ? 'text-green-600 bg-green-100 px-2 py-1 rounded text-xs'
                      : 'text-red-600 bg-red-100 px-2 py-1 rounded text-xs'">
                    {{ acc.status }}
                  </span>
                </td>

                <td class="p-3">
                  {{ new Date(acc.created_at).toLocaleDateString() }}
                </td>

              </tr>

              <tr v-if="accounts.data.length === 0">
                <td colspan="6" class="text-center p-6 text-gray-400">
                  No accounts found
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 flex justify-end space-x-2">
          <button v-if="accounts.prev_page_url"
            @click="router.get(accounts.prev_page_url)"
            class="px-3 py-1 border rounded-lg text-sm">
            Prev
          </button>

          <button v-if="accounts.next_page_url"
            @click="router.get(accounts.next_page_url)"
            class="px-3 py-1 border rounded-lg text-sm">
            Next
          </button>
        </div>

      </div>

    </div>
  </AdminLayout>
</template>