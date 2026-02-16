<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'

const page = usePage()
</script>

<template>
  <div class="min-h-screen flex bg-gray-100 ">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white p-4">
      <h2 class="text-xl font-bold mb-6">Mini Bank</h2>

      <nav class="space-y-3">
        <a href="/admin/dashboard" class="block hover:bg-gray-700 p-2 rounded">
          Dashboard
        </a>
        <a href="#" class="block hover:bg-gray-700 p-2 rounded">
          Users
        </a>
        <a href="#" class="block hover:bg-gray-700 p-2 rounded">
          Reports
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-semibold">Admin Panel</h1>
        <div>
          {{ page.props.auth.user?.name }}
        </div>
      </div>

      <slot />
    </main>

  </div>
</template>
