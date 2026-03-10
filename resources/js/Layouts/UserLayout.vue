<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'

const page = usePage()
const user = page.props.auth.user

const sidebarOpen = ref(false)
</script>

<template>

<div class="min-h-screen bg-gray-100 flex">

<!-- Sidebar -->
<aside
:class="[
'bg-white shadow-md w-64 p-4 fixed md:static inset-y-0 left-0 transform transition-transform duration-200',
sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'
]"
>

<h2 class="text-xl font-bold mb-6">
My Bank
</h2>

<nav class="space-y-2">

<Link
:href="route('user.dashboard')"
class="block px-3 py-2 rounded hover:bg-gray-100"
:class="{ 'bg-gray-100 font-medium': route().current('user.dashboard') }"
>
Dashboard
</Link>

<Link
:href="route('user.accounts.index')"
class="block px-3 py-2 rounded hover:bg-gray-100"
>
My Accounts
</Link>

<Link
:href="route('user.transactions.index')"
class="block px-3 py-2 rounded hover:bg-gray-100"
>
Transactions
</Link>

<Link
:href="route('profile.edit')"
class="block px-3 py-2 rounded hover:bg-gray-100"
>
Profile
</Link>

</nav>

</aside>


<!-- Main -->
<div class="flex-1 flex flex-col">

<!-- Navbar -->
<header class="bg-white shadow px-6 py-4 flex justify-between items-center">

<button
class="md:hidden"
@click="sidebarOpen = !sidebarOpen"
>
☰
</button>

<h1 class="font-semibold text-lg">
User Panel
</h1>

<div class="flex items-center gap-4">

<span class="text-sm text-gray-600">
{{ user.name }}
</span>

<Link
:href="route('logout')"
method="post"
as="button"
class="text-red-600 text-sm"
>
Logout
</Link>

</div>

</header>


<!-- Page Content -->
<main class="flex-1 p-6">

<slot />

</main>

</div>

</div>

</template>