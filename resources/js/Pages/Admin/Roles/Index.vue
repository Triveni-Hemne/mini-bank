<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, Head, useForm, usePage } from '@inertiajs/vue3'

const deleteUser = (id: number) => {
  if (confirm('Are you sure?')) {
    form.delete(route('roles.destroy', id))
  }
}
 
const props = defineProps({
  roles: Object,
  filters: Object
})

const form = useForm({
  search: props.filters.search || '',
  role: props.filters.role || ''
})

const applyFilters = () => {
  form.get(route('admin.roles.index'), {
    preserveState: true,
    replace: true
  })
}

const page = usePage()

const can = (permission: string) => {
  console.log(page.props.auth.user.permissions)
  return page.props.auth.user.permissions?.includes(permission)
}

</script>

<template>
  <AdminLayout>
    <Head title="Roles" />
    <div class="bg-white p-6 rounded shadow ">
    <div class="flex gap-4 mb-4">
      <!-- Search -->
      <input
        v-model="form.search"
        @input="applyFilters"
        placeholder="Search name or email..."
        class="border p-2 rounded w-64"
      />

      <!-- Role Filter -->
      <select
        v-model="form.role"
        @change="applyFilters"
        class="border p-2 rounded"
      >
        <option value="">All Roles</option>
        <option value="admin">Admin</option>
        <option value="staff">Staff</option>
        <option value="user">User</option>
      </select>
    </div>

 <table class="w-full border">
        <thead class="bg-gray-100">
          <tr>
          <th class="p-2 text-left">
            <h2 class="text-xl font-semibold mb-4">Roles &amp; Permissions</h2>
          </th>
          <th class="p-2 text-left">
            <Link v-if="can('create user')"
          :href="route('admin.roles.create')"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
          >
            + Add User
          </Link>
          </th>
          </tr>
        </thead>

      <div v-if="$page.props.flash.success"
          class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ $page.props.flash.success }}
      </div>

      <div v-if="$page.props.flash.error"
          class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        {{ $page.props.flash.error }}
      </div>

        <tbody>
        {{$roles}}
          <tr v-for="role in roles?.data || []" :key="role.id" class="border-t">
            <td class="p-2">{{ role.name }} 
              <Link v-if="can('create role')"
              :href="route('admin.roles.create')"
              class="text-dark px-4 py-2  rounded hover:bg-blue-600"
              >
                Manage Permissions
              </Link>
            </td>
            <td class="p-2">{{ role }}</td>           
          </tr> 
        </tbody>
      </table>
          <div class="mt-4 flex space-x-1">
        <template v-for="link in users?.links || []" :key="link.label">
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
