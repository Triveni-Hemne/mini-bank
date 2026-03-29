<script setup lang="ts">
import { Link, usePage, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const openReports = ref(false)
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

            <Link :href="route('admin.users.index')" 
            :class="[
                route().current('admin.users.*')
                ? 'bg-gray-700'
                : '',
                'block hover:bg-gray-700 p-2 rounded'
            ]"
            >
            Users
            </Link>
            <!-- Reports Dropdown -->
            <div>

              <!-- Parent -->
              <button
                @click="openReports = !openReports"
                class="w-full flex justify-between items-center p-2 rounded hover:bg-gray-700"
                :class="route().current('admin.reports.*') ? 'bg-gray-700' : ''"
              >
                <span>Reports</span>
                <span>{{ openReports ? '▲' : '▼' }}</span>
              </button>

              <!-- Children -->
              <div v-show="openReports" class="ml-4 mt-1 space-y-1">

                <Link
                  :href="route('admin.reports.transactions')"
                  class="block p-2 rounded hover:bg-gray-700"
                  :class="route().current('admin.reports.transactions') ? 'bg-gray-700' : ''"
                >
                  Transactions
                </Link>

                <Link
                  :href="route('admin.reports.customers')"
                  class="block p-2 rounded hover:bg-gray-700"
                  :class="route().current('admin.reports.customers') ? 'bg-gray-700' : ''"
                >
                  Customers
                </Link>
                
                <Link
                  :href="route('admin.reports.accounts')"
                  class="block p-2 rounded hover:bg-gray-700"
                  :class="route().current('admin.reports.accounts') ? 'bg-gray-700' : ''"
                >
                  Accounts
                </Link>
<!-- 
                <Link
                  :href="route('admin.reports.loans')"
                  class="block p-2 rounded hover:bg-gray-700"
                  :class="route().current('admin.reports.loans') ? 'bg-gray-700' : ''"
                >
                  Loans
                </Link>

                <Link
                  :href="route('admin.reports.daily')"
                  class="block p-2 rounded hover:bg-gray-700"
                  :class="route().current('admin.reports.daily') ? 'bg-gray-700' : ''"
                >
                  Daily Report
                </Link> -->

              </div>

            </div>

        <Link :href="route('admin.activity.index')" 
          :class="[
              route().current('admin.*')
              ? 'bg-gray-700'
              : '',
              'block hover:bg-gray-700 p-2 rounded'
          ]"
          >
          Audit Trail
          </Link>
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
