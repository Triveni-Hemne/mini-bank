<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { reactive } from 'vue'

const props = defineProps({
  customers: Object,
  totalCustomers: Number,
  totalBalance: Number,
  filters: Object
})

const formatCurrency = (amount) => {
  return new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: 'INR'
  }).format(amount)
}

const localFilters = reactive({
  search: props.filters?.search || '',
  from_date: props.filters?.from_date || '',
  to_date: props.filters?.to_date || ''
})

const filter = () => {
  router.get('/admin/reports/customers', localFilters, {
    preserveState: true,
    replace: true,
    preserveScroll: true
  })
}
</script>

<template>
  <AdminLayout>
    <Head title="Customer Reports" />

    <div class="p-6 bg-gray-50 min-h-screen">

      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">
          Customer Report
        </h2>
      </div>

      <!-- Filters -->
      <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <form @submit.prevent="filter" class="grid grid-cols-1 md:grid-cols-4 gap-4">

          <div>
            <label class="text-sm text-gray-500">Search</label>
            <input
              type="text"
              v-model="localFilters.search"
              placeholder="Name / Mobile"
              class="w-full mt-1 border rounded-lg px-3 py-2 text-sm"
            />
          </div>

          <div>
            <label class="text-sm text-gray-500">From Date</label>
            <input
              type="date"
              v-model="localFilters.from_date"
              class="w-full mt-1 border rounded-lg px-3 py-2 text-sm"
            />
          </div>

          <div>
            <label class="text-sm text-gray-500">To Date</label>
            <input
              type="date"
              v-model="localFilters.to_date"
              class="w-full mt-1 border rounded-lg px-3 py-2 text-sm"
            />
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
            <p class="text-gray-500 text-sm">Total Customers</p>
            <h3 class="text-lg font-bold text-blue-600">
              {{ totalCustomers }}
            </h3>
          </div>
          <div class="bg-blue-100 text-blue-600 p-3 rounded-full">👤</div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm flex justify-between items-center">
          <div>
            <p class="text-gray-500 text-sm">Total Balance</p>
            <h3 class="text-lg font-bold text-green-600">
              ₹{{ totalBalance }}
            </h3>
          </div>
          <div class="bg-green-100 text-green-600 p-3 rounded-full">₹</div>
        </div>

      </div>

      <!-- Table -->
      <div class="bg-white rounded-xl shadow-sm">

        <div class="p-4 flex justify-between items-center border-b">
          <h3 class="font-medium text-gray-700">Customers</h3>

          <div class="space-x-2">
            <button class="px-3 py-1 text-sm border rounded-lg">PDF</button>
            <button class="px-3 py-1 text-sm border rounded-lg">Excel</button>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
              <tr>
                <th class="text-left p-3">Name</th>
                <th class="text-left p-3">Email</th>
                <th class="text-center p-3">Accounts</th>
                <th class="text-right p-3">Balance</th>
                <th class="text-left p-3">Joined</th>
              </tr>
            </thead>

            <tbody>
              <tr
                v-for="customer in customers.data"
                :key="customer.id"
                class="border-b hover:bg-gray-50"
              >
                <td class="p-3 font-medium">
                  {{ customer.name }}
                </td>

                <td class="p-3">
                  {{ customer.email }}
                </td>

                <td class="p-3 text-center">
                  {{ customer.accounts.length }}
                </td>

                <td class="p-3 text-right font-semibold text-green-600">
                  {{ formatCurrency(
                    customer.accounts.reduce((sum, acc) => sum + Number(acc.balance), 0)
                    ) }}
                </td>
                <td class="p-3">
                  {{ new Date(customer.created_at).toLocaleDateString() }}
                </td>
              </tr>

              <tr v-if="customers.data.length === 0">
                <td colspan="5" class="text-center p-6 text-gray-400">
                  No customers found
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 flex justify-end space-x-2">
          <button
            v-if="customers.prev_page_url"
            @click="router.get(customers.prev_page_url)"
            class="px-3 py-1 border rounded-lg text-sm">
            Prev
          </button>

          <button
            v-if="customers.next_page_url"
            @click="router.get(customers.next_page_url)"
            class="px-3 py-1 border rounded-lg text-sm">
            Next
          </button>
        </div>

      </div>

    </div>
  </AdminLayout>
</template>