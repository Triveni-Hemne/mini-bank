<script setup>
import StaffLayout from '@/Layouts/StaffLayout.vue'
import { useForm, Head } from '@inertiajs/vue3'

const props = defineProps({ users: Array })

const form = useForm({
  user_id: '',
  account_type: 'savings'
})

const submit = () => {
  form.post(route('staff.accounts.store'))
}
</script>

<template>
  <StaffLayout>
    <Head title="Create Account" />

    <div class="bg-white p-6 rounded shadow max-w-xl">
      <h2 class="text-xl font-semibold mb-4">Create Account</h2>

      <form @submit.prevent="submit" class="space-y-4">

        <select v-model="form.user_id" class="w-full border p-2 rounded">
          <option value="">Select User</option>
          <option v-for="user in users" :key="user.id" :value="user.id">
            {{ user.name }} ({{ user.email }})
          </option>
        </select>

        <select v-model="form.account_type" class="w-full border p-2 rounded">
          <option value="savings">Savings</option>
          <option value="current">Current</option>
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
          Create Account
        </button>

      </form>
    </div>
  </StaffLayout>
</template>