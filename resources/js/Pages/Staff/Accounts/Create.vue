<script setup>
import StaffLayout from '@/Layouts/StaffLayout.vue'
import { useForm } from '@inertiajs/vue3'

defineOptions({ layout: StaffLayout })

const props = defineProps({
  users: Array
})

const form = useForm({
  user_id: '',
  account_type: '',
  opening_balance: '',
  status: 'active',
})

const submit = () => {
  form.post(route('staff.accounts.store'))
}
</script>

<template>
  <div class="max-w-xl mx-auto">

    <!-- Title -->
    <div class="mb-6">
      <h2 class="text-2xl font-semibold text-gray-800">
        Create Account
      </h2>
      <p class="text-gray-500 text-sm">
        Create a new account for an existing member.
      </p>
    </div>

    <!-- Card -->
    <div class="bg-white shadow rounded-xl p-6">

      <form @submit.prevent="submit" class="space-y-6">

        <!-- User -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Select User
          </label>

          <select
            v-model="form.user_id"
            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
          >
            <option value="">Choose user</option>
            <option
              v-for="user in users"
              :key="user.id"
              :value="user.id"
            >
              {{ user.name }} ({{ user.email }})
            </option>
          </select>

          <div v-if="form.errors.user_id" class="text-red-500 text-sm mt-1">
            {{ form.errors.user_id }}
          </div>
        </div>

        <!-- Account Type -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Account Type
          </label>

          <select
            v-model="form.account_type"
            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
          >
            <option value="">Select type</option>
            <option value="savings">Savings</option>
            <option value="current">Current</option>
            <option value="loan">Loan</option>
          </select>

          <div v-if="form.errors.account_type" class="text-red-500 text-sm mt-1">
            {{ form.errors.account_type }}
          </div>
        </div>

        <!-- Opening Balance -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Opening Balance
          </label>

          <input
            type="number"
            step="0.01"
            v-model="form.opening_balance"
            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
          />

          <div v-if="form.errors.opening_balance" class="text-red-500 text-sm mt-1">
            {{ form.errors.opening_balance }}
          </div>
        </div>

        <!-- Status -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Status
          </label>

          <select
            v-model="form.status"
            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
          >
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>

          <div v-if="form.errors.status" class="text-red-500 text-sm mt-1">
            {{ form.errors.status }}
          </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-3">

          <button
            type="button"
            @click="$inertia.visit(route('staff.accounts.index'))"
            class="px-5 py-2 rounded-lg border"
          >
            Cancel
          </button>

          <button
            type="submit"
            :disabled="form.processing"
            class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
          >
            Create Account
          </button>

        </div>

      </form>
    </div>
  </div>
</template>