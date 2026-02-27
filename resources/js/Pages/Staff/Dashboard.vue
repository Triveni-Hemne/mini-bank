<script setup>
import { Link } from '@inertiajs/vue3'
import StaffLayout from '@/Layouts/StaffLayout.vue'
defineProps({ 
stats: Object,
recentTransactions: Array
})
</script>

<template>
  <StaffLayout>
    <div class="mb-8 flex flex-wrap gap-4">
      <Link
        :href="route('staff.accounts.create')"
        class="px-5 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition"
      >
        ➕ Create Account
      </Link>

      <Link
        :href="route('staff.transactions.index')"
        class="px-5 py-3 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition"
      >
        💰 Manage Transactions
      </Link>

      <Link
        :href="route('staff.accounts.index')"
        class="px-5 py-3 bg-gray-800 text-white rounded-lg shadow hover:bg-gray-900 transition"
      >
        📄 View Accounts
      </Link>

</div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">

  <!-- Total Accounts -->
  <div class="bg-blue-50 border border-blue-100 p-6 rounded-2xl shadow-sm">
    <div class="flex justify-between items-center">
      <h2 class="text-sm text-blue-600 font-medium">
        Total Accounts
      </h2>
      <span class="text-xl">🏦</span>
    </div>
    <p class="text-3xl font-bold mt-4 text-blue-900">
      {{ stats.totalAccounts }}
    </p>
  </div>

  <!-- Total Deposits -->
  <div class="bg-green-50 border border-green-100 p-6 rounded-2xl shadow-sm">
    <div class="flex justify-between items-center">
      <h2 class="text-sm text-green-600 font-medium">
        Total Deposits
      </h2>
      <span class="text-xl">📈</span>
    </div>
    <p class="text-3xl font-bold mt-4 text-green-800">
      ₹ {{ stats.totalDeposits }}
    </p>
  </div>

  <!-- Total Withdrawals -->
  <div class="bg-red-50 border border-red-100 p-6 rounded-2xl shadow-sm">
    <div class="flex justify-between items-center">
      <h2 class="text-sm text-red-600 font-medium">
        Total Withdrawals
      </h2>
      <span class="text-xl">📉</span>
    </div>
    <p class="text-3xl font-bold mt-4 text-red-800">
      ₹ {{ stats.totalWithdrawals }}
    </p>
  </div>

  <!-- System Balance -->
  <div class="bg-indigo-50 border border-indigo-100 p-6 rounded-2xl shadow-sm">
    <div class="flex justify-between items-center">
      <h2 class="text-sm text-indigo-600 font-medium">
        System Balance
      </h2>
      <span class="text-xl">💰</span>
    </div>
    <p class="text-3xl font-bold mt-4 text-indigo-900">
      ₹ {{ stats.systemBalance }}
    </p>
  </div>

  <!-- Today's Transactions -->
  <div class="bg-yellow-50 border border-yellow-100 p-6 rounded-2xl shadow-sm">
    <div class="flex justify-between items-center">
      <h2 class="text-sm text-yellow-600 font-medium">
        Today's Transactions
      </h2>
      <span class="text-xl">⚡</span>
    </div>
    <p class="text-3xl font-bold mt-4 text-yellow-800">
      {{ stats.todayTransactions }}
    </p>
  </div>

</div>

    <div class="mt-10 bg-white rounded-xl shadow">
      <div class="p-6 border-b">
        <h2 class="text-lg font-semibold">Recent Transactions</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
          <thead class="bg-gray-50">
            <tr>
              <th class="p-4">Date</th>
              <th class="p-4">Account</th>
              <th class="p-4">User</th>
              <th class="p-4">Type</th>
              <th class="p-4">Amount</th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="txn in recentTransactions"
              :key="txn.id"
              class="border-t hover:bg-gray-50"
            >
              <td class="p-4">
                {{ new Date(txn.created_at).toLocaleDateString() }}
              </td>

              <td class="p-4">
                {{ txn.account.account_number }}
              </td>

              <td class="p-4">
                {{ txn.account.user.name }}
              </td>

              <td class="p-4">
                <span
                  :class="txn.type === 'credit'
                    ? 'text-green-600 font-semibold'
                    : 'text-red-600 font-semibold'"
                >
                  {{ txn.type }}
                </span>
              </td>

              <td class="p-4 font-medium">
                ₹ {{ txn.amount }}
              </td>
            </tr>

            <tr v-if="recentTransactions.length === 0">
              <td colspan="5" class="p-4 text-center text-gray-500">
                No transactions yet.
              </td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>

  </StaffLayout>
</template>