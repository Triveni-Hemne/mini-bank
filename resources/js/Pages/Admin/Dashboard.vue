<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const page = usePage()
</script>

<template>
  <AdminLayout>
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-xl font-semibold">
        Welcome {{ page.props.auth.user?.name }}
      </h2>
    </div>
  </AdminLayout>
</template>
