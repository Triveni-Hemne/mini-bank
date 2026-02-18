<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, Head, useForm } from '@inertiajs/vue3'

const form = useForm({})

const deleteUser = (id: number) => {
  if (confirm('Are you sure?')) {
    form.delete(route('users.destroy', id))
  }
}
 
defineProps({
  users: Object
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

      <div v-if="$page.props.flash.success"
          class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ $page.props.flash.success }}
      </div>

      <div v-if="$page.props.flash.error"
          class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        {{ $page.props.flash.error }}
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
          <tr v-for="user in users.data" :key="user.id" class="border-t">
            <td class="p-2">{{ user.name }}</td>
            <td class="p-2">{{ user.email }}</td>
            <td class="p-2">
              <span
                class="px-2 py-1 text-xs rounded font-semibold"
                :class="{
                  'bg-red-100 text-red-700': user.role === 'admin',
                  'bg-blue-100 text-blue-700': user.role === 'staff',
                  'bg-gray-100 text-gray-700': user.role === 'user'
                }"
              >
                {{ user.role }}
              </span>
            </td>
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
          <div class="mt-4 flex space-x-1">
        <template v-for="link in users.links" :key="link.label">
          <Link
            v-if="link.url"
            :href="link.url"
            v-html="link.label"
            class="px-3 py-1 border rounded text-sm"
            :class="{
              'bg-blue-600 text-white': link.active,
              'text-gray-700': !link.active
            }"
          />
          <span
            v-else
            v-html="link.label"
            class="px-3 py-1 border rounded text-gray-400 text-sm"
          />
        </template>
    </div>

    </div>
  </AdminLayout>
</template>
