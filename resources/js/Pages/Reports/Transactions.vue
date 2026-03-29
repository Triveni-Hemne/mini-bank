<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { reactive } from 'vue'

const props = defineProps({
  transactions: Object,
  accounts: Array,
  totalCredit: Number,
  totalDebit: Number,
  filters: Object
})

const localFilters = reactive({
  from_date: props.filters?.from_date || '',
  to_date: props.filters?.to_date || '',
  account_id: props.filters?.account_id || '',
  type: props.filters?.type || ''
})

const filter = (e) => {
  e.preventDefault()

  router.get('/admin/reports/transactions', localFilters, {
    preserveState: true,
    replace: true,
    preserveScroll: true
  })
}
</script>

<template>
  <AdminLayout>
    <Head title="Transaction Reports" />

    <div class="p-6 bg-gray-50 min-h-screen">

      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">
          Transaction Report
        </h2>
      </div>

      <!-- Filters -->
      <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <form @submit.prevent="filter" class="grid grid-cols-1 md:grid-cols-4 gap-4">

          <div>
            <label class="text-sm text-gray-500">From Date</label>
            <input type="date" v-model="localFilters.from_date"
              class="w-full mt-1 border rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200">
          </div>

          <div>
            <label class="text-sm text-gray-500">To Date</label>
            <input type="date" v-model="localFilters.to_date"
              class="w-full mt-1 border rounded-lg px-3 py-2 text-sm">
          </div>

          <div>
            <label class="text-sm text-gray-500">Account</label>
            <select v-model="localFilters.account_id"
              class="w-full mt-1 border rounded-lg px-3 py-2 text-sm">
              <option value="">All</option>
              <option v-for="acc in accounts" :key="acc.id" :value="acc.id">
                {{ acc.account_number }}
              </option>
            </select>
          </div>

          <div>
            <label class="text-sm text-gray-500">Type</label>
            <select v-model="localFilters.type"
              class="w-full mt-1 border rounded-lg px-3 py-2 text-sm">
              <option value="">All</option>
              <option value="credit">Credit</option>
              <option value="debit">Debit</option>
            </select>
          </div>

          <div class="flex items-end">
            <button
              class="w-full bg-black text-white rounded-lg py-2 text-sm hover:bg-gray-800 transition">
              Apply
            </button>
          </div>

        </form>
      </div>

      <!-- Summary -->
      <div class="grid md:grid-cols-2 gap-6 mb-6">

        <div class="bg-white p-4 rounded-xl shadow-sm flex justify-between items-center">
          <div>
            <p class="text-gray-500 text-sm">Total Credit</p>
            <h3 class="text-lg font-bold text-green-600">₹{{ totalCredit }}</h3>
          </div>
          <div class="bg-green-100 text-green-600 p-3 rounded-full">↑</div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm flex justify-between items-center">
          <div>
            <p class="text-gray-500 text-sm">Total Debit</p>
            <h3 class="text-lg font-bold text-red-600">₹{{ totalDebit }}</h3>
          </div>
          <div class="bg-red-100 text-red-600 p-3 rounded-full">↓</div>
        </div>

      </div>

      <!-- Table -->
      <div class="bg-white rounded-xl shadow-sm">

        <div class="p-4 flex justify-between items-center border-b">
          <h3 class="font-medium text-gray-700">Transactions</h3>

          <div class="space-x-2">
            <button class="px-3 py-1 text-sm border rounded-lg">PDF</button>
            <button class="px-3 py-1 text-sm border rounded-lg">Excel</button>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
              <tr>
                <th class="text-left p-3">Date</th>
                <th class="text-left p-3">Account</th>
                <th class="text-left p-3">Customer</th>
                <th class="text-left p-3">Type</th>
                <th class="text-right p-3">Amount</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="txn in transactions.data" :key="txn.id"
                  class="border-b hover:bg-gray-50">
          
                <td class="p-3">
                  {{ new Date(txn.created_at).toLocaleDateString() }}
                </td>

                <td class="p-3">
                  {{ txn.account.account_number }}
                </td>

                <td class="p-3">
                  {{ txn.account.user.name }}
                </td>

                <td class="p-3">
                  <span
                    :class="txn.type === 'credit'
                      ? 'text-green-600 bg-green-100 px-2 py-1 rounded text-xs'
                      : 'text-red-600 bg-red-100 px-2 py-1 rounded text-xs'">
                    {{ txn.type }}
                  </span>
                </td>

                <td class="p-3 text-right font-semibold"
                    :class="txn.type === 'credit' ? 'text-green-600' : 'text-red-600'">
                  ₹{{ txn.amount }}
                </td>

              </tr>

              <tr v-if="transactions.data.length === 0">
                <td colspan="5" class="text-center p-6 text-gray-400">
                  No transactions found
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 flex justify-end space-x-2">
          <button
            v-if="transactions.prev_page_url"
            @click="router.get(transactions.prev_page_url)"
            class="px-3 py-1 border rounded-lg text-sm">
            Prev
          </button>

          <button
            v-if="transactions.next_page_url"
            @click="router.get(transactions.next_page_url)"
            class="px-3 py-1 border rounded-lg text-sm">
            Next
          </button>
        </div>

      </div>

    </div>
  </AdminLayout>
</template>