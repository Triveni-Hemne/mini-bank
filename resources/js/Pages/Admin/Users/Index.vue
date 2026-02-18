<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, Head, useForm } from '@inertiajs/vue3'

const form = useForm({})

const deleteUser = (id: number) => {
  if (confirm('Are you sure?')) {
    form.delete(route('admin.users.destroy', id))
  }
}
 
defineProps({
  users: Array
})
</script>

<template>
  <AdminLayout>
    <Head title="Users" />
    <div class="bg-white p-6 rounded shadow ">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold mb-4">Users</h2>
      <Link
    :href="route('users.create')"
    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
  >
    + Add User
  </Link>
  </div>

      <table class="w-full border">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2 text-left">Name</th>
            <th class="p-2 text-left">Email</th>
            <th class="p-2 text-left">Role</th>
            <th class="p-2 text-left">Created</th>
            <th class="p-2 text-left">Actions</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="user in users" :key="user.id" class="border-t">
            <td class="p-2">{{ user.name }}</td>
            <td class="p-2">{{ user.email }}</td>
            <td class="p-2 capitalize">{{ user.role }}</td>
            <td class="p-2">
              {{ new Date(user.created_at).toLocaleDateString() }}
            </td>
            <td class="p-2 space-x-2">
              <Link
                :href="route('users.edit', user.id)"
                class="text-blue-600 hover:underline"
              >
                Edit
              </Link>
              <button
                @click="deleteUser(user.id)"
                class="text-red-600 hover:underline"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AdminLayout>
</template>
