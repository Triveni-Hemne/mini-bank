<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, Head } from '@inertiajs/vue3'

const props = defineProps({
  user: Object
})

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  password: '',
  role: props.user.role
})

const submit = () => {
  form.put(route('users.update', props.user.id))
}
  
</script>

<template>
  <AdminLayout>
    <Head title="Edit User" />

    <div class="bg-white p-6 rounded shadow max-w-xl">
      <h2 class="text-xl font-semibold mb-6">Edit User</h2>

      <form @submit.prevent="submit" class="space-y-4">

        <div>
          <label>Name</label>
          <input v-model="form.name" class="w-full border p-2 rounded" />
          <div v-if="form.errors.name" class="text-red-500 text-sm">
            {{ form.errors.name }}
          </div>
        </div>

        <div>
          <label>Email</label>
          <input v-model="form.email" class="w-full border p-2 rounded" />
          <div v-if="form.errors.email" class="text-red-500 text-sm">
            {{ form.errors.email }}
          </div>
        </div>

        <div>
          <label>New Password (optional)</label>
          <input
            type="password"
            v-model="form.password"
            class="w-full border p-2 rounded"
          />
        </div>

        <div>
          <label>Role</label>
          <select v-model="form.role" class="w-full border p-2 rounded">
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
            <option value="user">User</option>
          </select>
        </div>

        <button
          type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded"
          :disabled="form.processing"
        >
          Update
        </button>

      </form>
    </div>
  </AdminLayout>
</template>