<script setup>
import StaffLayout from '@/Layouts/StaffLayout.vue'
import { Link } from '@inertiajs/vue3'

defineOptions({ layout: StaffLayout })

defineProps({
  account: Object
})
</script>

<template>

<div class="max-w-6xl mx-auto">

  <!-- Header -->
  <div class="flex justify-between items-center mb-6">

    <div>
      <h1 class="text-2xl font-semibold text-gray-800">
        Account Details
      </h1>
      <p class="text-sm text-gray-500">
        Account #{{ account.account_number }}
      </p>
    </div>

    <Link
      :href="route('staff.accounts.index')"
      class="px-4 py-2 border rounded-lg"
    >
      Back
    </Link>

  </div>

  <!-- Account Card -->
  <div class="bg-white shadow rounded-xl p-6 mb-6">

    <h2 class="text-lg font-semibold mb-4">
      Account Information
    </h2>

    <div class="grid grid-cols-2 gap-6">

      <div>
        <p class="text-sm text-gray-500">Account Number</p>
        <p class="font-medium">{{ account.account_number }}</p>
      </div>

      <div>
        <p class="text-sm text-gray-500">Account Type</p>
        <p class="capitalize">{{ account.account_type }}</p>
      </div>

      <div>
        <p class="text-sm text-gray-500">Balance</p>
        <p class="font-semibold text-lg">
          ₹ {{ account.balance }}
        </p>
      </div>

      <div>
        <p class="text-sm text-gray-500">Status</p>

        <span
          class="px-2 py-1 rounded text-xs font-medium"
          :class="account.status === 'active'
            ? 'bg-green-100 text-green-700'
            : 'bg-gray-200 text-gray-700'"
        >
          {{ account.status }}
        </span>

      </div>

      <div>
        <p class="text-sm text-gray-500">Created</p>
        <p>{{ account.created_at }}</p>
      </div>

    </div>

  </div>

  <!-- Member Card -->
  <div class="bg-white shadow rounded-xl p-6 mb-6">

    <h2 class="text-lg font-semibold mb-4">
      Account Holder
    </h2>

    <div class="grid grid-cols-2 gap-6">

      <div>
        <p class="text-sm text-gray-500">Name</p>
        <p class="font-medium">{{ account.user.name }}</p>
      </div>

      <div>
        <p class="text-sm text-gray-500">Email</p>
        <p>{{ account.user.email }}</p>
      </div>

    </div>

  </div>

  <!-- Actions -->
  <div class="bg-white shadow rounded-xl p-6">

    <h2 class="text-lg font-semibold mb-4">
      Account Actions
    </h2>

    <div class="flex gap-4">

      <Link
        href="#"
        class="px-4 py-2 bg-green-600 text-white rounded-lg"
      >
        Deposit
      </Link>

      <Link
        href="#"
        class="px-4 py-2 bg-red-600 text-white rounded-lg"
      >
        Withdraw
      </Link>

      <Link
        href="#"
        class="px-4 py-2 bg-gray-700 text-white rounded-lg"
      >
        View Statement
      </Link>

    </div>

  </div>

</div>

</template>