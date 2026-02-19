<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, Head } from '@inertiajs/vue3'

const form = useForm({
  name: '',
  email: '',
  password: '',
  role: 'user',
  status: 'active'
})

const submit = () => {
  form.post(route('users.store'))
}
</script>

<template>
  <AdminLayout>
    <Head title="Create User" />

    <div class="bg-white p-6 rounded shadow max-w-xl">
      <h2 class="text-xl font-semibold mb-6">Create User</h2>

      <form @submit.prevent="submit" class="space-y-4">

        <!-- Name -->
        <div>
          <label class="block text-sm mb-1">Name</label>
          <input
            v-model="form.name"
            type="text"
            class="w-full border p-2 rounded"
          />
          <div v-if="form.errors.name" class="text-red-500 text-sm">
            {{ form.errors.name }}
          </div>
        </div>

        <!-- Email -->
        <div>
          <label class="block text-sm mb-1">Email</label>
          <input
            v-model="form.email"
            type="email"
            class="w-full border p-2 rounded"
          />
          <div v-if="form.errors.email" class="text-red-500 text-sm">
            {{ form.errors.email }}
          </div>
        </div>

        <!-- Password -->
        <div>
          <label class="block text-sm mb-1">Password</label>
          <input
            v-model="form.password"
            type="password"
            class="w-full border p-2 rounded"
          />
          <div v-if="form.errors.password" class="text-red-500 text-sm">
            {{ form.errors.password }}
          </div>
        </div>

        <!-- Role -->
        <div>
          <label class="block text-sm mb-1">Role</label>
          <select
            v-model="form.role"
            class="w-full border p-2 rounded"
          >
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
            <option value="user">User</option>
          </select>
        </div>

        <div>
        <label class="block text-sm mb-1">Status</label>
        <select v-model="form.status" class="w-full border p-2 rounded">
          <option value="active">Active</option>
          <option value="suspended">Suspended</option>
        </select>
      </div>


        <button
          type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
          :disabled="form.processing"
        >
          Create
        </button>

      </form>
    </div>
  </AdminLayout>
</template>
