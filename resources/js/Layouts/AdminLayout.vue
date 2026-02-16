<script setup lang="ts">
import { Link, usePage, useForm } from '@inertiajs/vue3'

const page = usePage()
const form = useForm({})
</script>

<template>
  <div class="min-h-screen flex bg-gray-100 ">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white p-4">
      <h2 class="text-xl font-bold mb-6">Mini Bank</h2>

      <nav class="space-y-3 mb-2">
        <Link
            :href="route('admin.dashboard')"
            :class="[
                route().current('admin.dashboard')
                ? 'bg-gray-700'
                : '',
                'block hover:bg-gray-700 p-2 rounded'
            ]"
            >
            Dashboard
            </Link>

            <Link :href="route('users.index')" 
            :class="[
                route().current('users.*')
                ? 'bg-gray-700'
                : '',
                'block hover:bg-gray-700 p-2 rounded'
            ]"
            >
            Users
            </Link>
        <a href="/admin/users" class="block hover:bg-gray-700 p-2 rounded">
          Reports
        </a>
      </nav>
      
      <div class="mt-10 border-t border-gray-700 pt-4">
        <button
            @click="form.post(route('logout'))"
            class="w-full text-left p-2 rounded text-gray-300 hover:bg-red-600 hover:text-white transition"
        >
            Logout
        </button>
        </div>
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
