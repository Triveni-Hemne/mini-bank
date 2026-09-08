<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { ref, reactive } from 'vue'

const props = defineProps({
  transactions: Object,
  accounts: Array
})

// 🧠 State
const showModal = ref(false)
const editMode = ref(false)
const selectedId = ref(null)

const form = reactive({
  account_id: '',
  type: 'credit',
  amount: '',
  payment_mode: '',
  description: ''
})

// 💰 Formatter
const formatCurrency = (amount) => {
  return new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: 'INR'
  }).format(amount)
}

// ➕ Open Add Modal
const openAdd = () => {
  editMode.value = false
  showModal.value = true
  Object.assign(form, {
    account_id: '',
    type: 'credit',
    amount: '',
    payment_mode: '',
    description: ''
  })
}

// ✏️ Open Edit Modal
const openEdit = (txn) => {
  editMode.value = true
  showModal.value = true
  selectedId.value = txn.id

  Object.assign(form, {
    account_id: txn.account_id,
    type: txn.type,
    amount: txn.amount,
    payment_mode: txn.payment_mode,
    description: txn.description
  })
}

// 💾 Save
const submit = () => {
  if (editMode.value) {
    router.put(`/admin/transactions/${selectedId.value}`, form)
  } else {
    router.post('/admin/transactions', form)
  }

  showModal.value = false
}

// ❌ Delete
const destroy = (id) => {
  if (confirm('Are you sure?')) {
    router.delete(`/admin/transactions/${id}`)
  }
}
</script>

<template>
  <AdminLayout>
    <Head title="Manage Transactions" />

    <div class="p-6 bg-gray-50 min-h-screen">

      <!-- Header -->
      <div class="flex justify-between mb-6">
        <h2 class="text-xl font-semibold">Transactions</h2>
        <button @click="openAdd"
          class="bg-black text-white px-4 py-2 rounded-lg text-sm">
          + Add Transaction
        </button>
      </div>

      <!-- Table -->
      <div class="bg-white rounded-xl shadow-sm">

        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-gray-100">
              <tr>
                <th class="p-3 text-left">Date</th>
                <th class="p-3 text-left">Account</th>
                <th class="p-3 text-left">Customer</th>
                <th class="p-3 text-left">Type</th>
                <th class="p-3 text-right">Amount</th>
                <th class="p-3 text-right">Actions</th>
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
                  <span :class="txn.type === 'credit'
                    ? 'text-green-600 bg-green-100 px-2 py-1 rounded text-xs'
                    : 'text-red-600 bg-red-100 px-2 py-1 rounded text-xs'">
                    {{ txn.type }}
                  </span>
                </td>

                <td class="p-3 text-right font-semibold"
                    :class="txn.type === 'credit' ? 'text-green-600' : 'text-red-600'">
                  {{ formatCurrency(txn.amount) }}
                </td>

                <td class="p-3 text-right space-x-2">
                  <button @click="openEdit(txn)"
                    class="text-blue-600 text-sm">Edit</button>
                  <button @click="destroy(txn.id)"
                    class="text-red-600 text-sm">Delete</button>
                </td>

              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 flex justify-end space-x-2">
          <button v-if="transactions.prev_page_url"
            @click="router.get(transactions.prev_page_url)"
            class="px-3 py-1 border rounded-lg text-sm">
            Prev
          </button>

          <button v-if="transactions.next_page_url"
            @click="router.get(transactions.next_page_url)"
            class="px-3 py-1 border rounded-lg text-sm">
            Next
          </button>
        </div>

      </div>

      <!-- Modal -->
      <div v-if="showModal"
        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">

        <div class="bg-white w-full max-w-md rounded-xl p-6">

          <h3 class="text-lg font-semibold mb-4">
            {{ editMode ? 'Edit Transaction' : 'Add Transaction' }}
          </h3>

          <div class="space-y-3">

            <select v-model="form.account_id" class="w-full border rounded-lg p-2">
              <option value="">Select Account</option>
              <option v-for="acc in accounts" :key="acc.id" :value="acc.id">
                {{ acc.account_number }}
              </option>
            </select>

            <select v-model="form.type" class="w-full border rounded-lg p-2">
              <option value="credit">Credit</option>
              <option value="debit">Debit</option>
            </select>

            <input v-model="form.amount" type="number"
              placeholder="Amount"
              class="w-full border rounded-lg p-2" />

            <!-- <input v-model="form.payment_mode"
              placeholder="Payment Mode"
              class="w-full border rounded-lg p-2" /> -->

            <textarea v-model="form.description"
              placeholder="Description"
              class="w-full border rounded-lg p-2"></textarea>

          </div>

          <div class="flex justify-end mt-4 space-x-2">
            <button @click="showModal = false"
              class="px-4 py-2 border rounded-lg">Cancel</button>

            <button @click="submit"
              class="px-4 py-2 bg-black text-white rounded-lg">
              Save
            </button>
          </div>

        </div>
      </div>

    </div>
  </AdminLayout>
</template>