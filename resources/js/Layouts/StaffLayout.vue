<script setup>
import { Link, usePage, router } from '@inertiajs/vue3'
import { ref,onMounted  } from 'vue'

const page = usePage()
const showDropdown = ref(false)
const isCollapsed = ref(false)
const isMobileOpen = ref(false)

const isActive = (routeName) => {
  return route().current(routeName)
}

const logout = () => {
  router.post(route('logout'))
}
const toggleSidebar = () => {
  isCollapsed.value = !isCollapsed.value
  localStorage.setItem('sidebarCollapsed', isCollapsed.value)
}
const toggleMobileSidebar = () => {
  isMobileOpen.value = !isMobileOpen.value
}

onMounted(() => {
  const savedState = localStorage.getItem('sidebarCollapsed')
  if (savedState !== null) {
    isCollapsed.value = savedState === 'true'
  }

  // Auto collapse on small screens
  if (window.innerWidth < 1024) {
    isCollapsed.value = true
  }
})

const navClass = (routeName) => {
  return [
    'flex items-center px-3 py-2 rounded-lg transition-all duration-200 group',
    isActive(routeName)
      ? 'bg-gray-800 border-l-4 border-blue-500 text-white'
      : 'hover:bg-gray-800 hover:text-white'
  ]
}
</script>

<template>
  <div class="flex h-screen bg-gray-100 relative">
    <!-- Mobile Overlay -->
<div
  v-if="isMobileOpen"
  @click="isMobileOpen = false"
  class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
></div>
    <!-- Sidebar -->
    <aside
  :class="[
    'fixed lg:static z-50 top-0 left-0 h-full bg-gray-900 text-gray-200 transition-all duration-300 flex flex-col',
    isMobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
    isCollapsed ? 'w-20' : 'w-64'
  ]"
>

  <!-- Logo + Toggle -->
  <div class="flex items-center justify-between p-4 border-b border-gray-800">

    <transition name="fade">
      <span v-if="!isCollapsed" class="font-bold text-lg tracking-wide">
        Staff Panel
      </span>
    </transition>

    <button
      @click="toggleSidebar"
      class="p-2 rounded hover:bg-gray-800 transition"
    >
      ☰
    </button>

  </div>

  <!-- Navigation -->
  <nav class="flex-1 p-3 space-y-1">

    <!-- Dashboard -->
    <Link
      :href="route('staff.dashboard')"
      :class="[
        navClass('staff.dashboard')
      ]"
    >
      <span class="text-lg">🏠</span>

      <transition name="fade">
        <span v-if="!isCollapsed" class="ml-3">
          Dashboard
        </span>
      </transition>
    </Link>

    <!-- Accounts -->
    <Link
      :href="route('staff.accounts.index')"
      :class="[
        navClass('staff.accounts.*')
      ]"
    >
      <span class="text-lg">🏦</span>

      <transition name="fade">
        <span v-if="!isCollapsed" class="ml-3">
          Accounts
        </span>
      </transition>
    </Link>

    <!-- Transactions -->
    <Link
      :href="route('staff.transactions.index')"
      :class="[
        navClass('staff.transactions.*')
      ]"
    >
      <span class="text-lg">💸</span>

      <transition name="fade">
        <span v-if="!isCollapsed" class="ml-3">
          Transactions
        </span>
      </transition>
    </Link>

  </nav>

</aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

      <!-- Topbar -->
     <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
<button
  @click="toggleMobileSidebar"
  class="lg:hidden p-2 mr-3 rounded hover:bg-gray-200 transition"
>
  ☰
</button>
  <h1 class="text-lg font-semibold text-gray-700">
    Staff Panel
  </h1>

  <!-- User Dropdown -->
  <div class="relative">

    <button
      @click="showDropdown = !showDropdown"
      class="flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition"
    >
      <span class="text-sm font-medium">
        {{ $page.props.auth.user.name }}
      </span>
      <span>▾</span>
    </button>

    <!-- Dropdown Menu -->
    <div
      v-if="showDropdown"
      class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-lg"
    >
      <Link
        href="#"
        class="block px-4 py-2 text-sm hover:bg-gray-100"
      >
        Profile
      </Link>

      <button
        @click="logout"
        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
      >
        Logout
      </button>
    </div>

  </div>

</header>

      <!-- Page Content -->
      <main class="flex-1 p-6 overflow-y-auto">
        <slot />
      </main>

    </div>
  </div>
</template>


<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>