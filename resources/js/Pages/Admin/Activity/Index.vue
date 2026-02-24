<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head } from '@inertiajs/vue3'

defineProps({
  logs: Object
})
</script>

<template>
  <AdminLayout>
    <Head title="Activity Logs" />

    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-xl font-semibold mb-4">Activity Logs</h2>

      <table class="w-full border">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2 text-left">Action</th>
            <th class="p-2 text-left">User</th>
            <th class="p-2 text-left">Model</th>
            <th class="p-2 text-left">Date</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="log in logs.data" :key="log.id" class="border-t">
            <td class="p-2">{{ log.user?.name }}</td>
            <td class="p-2">{{ log.action }}</td>
            <td class="p-2">{{ log.model }}</td>
            <td class="p-2">
              {{ new Date(log.created_at).toLocaleString() }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AdminLayout>
</template>
