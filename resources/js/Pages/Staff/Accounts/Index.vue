<script setup>
import StaffLayout from '@/Layouts/StaffLayout.vue'
import { Link } from '@inertiajs/vue3'

defineOptions({ layout: StaffLayout })

defineProps({
  accounts: Object
})
</script>

<template>
<div class="max-w-7xl mx-auto">
  <!-- Header -->
  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-2xl font-semibold text-gray-800">
        Accounts
      </h1>
      <p class="text-sm text-gray-500">
        Manage member accounts
      </p>
    </div>
    <Link
      :href="route('staff.accounts.create')"
      class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
    >
      + Create Account
    </Link>
  </div>
  <!-- Table -->
  <div class="bg-white shadow rounded-xl overflow-hidden">
    <table class="w-full text-sm">
      <thead class="bg-gray-50 text-left">
        <tr>
          <th class="p-4">Account #</th>
          <th class="p-4">Holder</th>
          <th class="p-4">Type</th>
          <th class="p-4">Balance</th>
          <th class="p-4">Status</th>
          <th class="p-4">Created</th>
          <th class="p-4"></th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="account in accounts.data"
          :key="account.id"
          class="border-t hover:bg-gray-50"
        >
          <td class="p-4 font-medium">
            {{ account.account_number }}
          </td>
          <td class="p-4">
            {{ account.user_name }}
          </td>
          <td class="p-4 capitalize">
            {{ account.account_type }}
          </td>
          <td class="p-4 font-semibold">
            ₹ {{ account.balance }}
          </td>
          <td class="p-4">
            <span
              class="px-2 py-1 rounded text-xs font-medium"
              :class="account.status === 'active'
                ? 'bg-green-100 text-green-700'
                : 'bg-gray-200 text-gray-700'"
            >
              {{ account.status }}
            </span>
          </td>
          <td class="p-4">
            {{ account.created_at }}
          </td>
          <td class="p-4">
            <Link
              :href="route('staff.accounts.show', account.id)"
              class="text-blue-600 hover:underline"
            >
              View
            </Link>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
</template>