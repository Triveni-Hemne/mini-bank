<script setup>
import UserLayout from '@/Layouts/UserLayout.vue'

defineProps({
  accounts: Array
})

defineOptions({
  layout: UserLayout
})
</script>

<template>

<div>

<h1 class="text-2xl font-semibold mb-6">
My Accounts
</h1>

<div class="grid md:grid-cols-2 gap-6">

<div
v-for="account in accounts"
:key="account.id"
class="bg-white p-6 rounded-xl shadow"
>

<p class="text-sm text-gray-500">
Account Number
</p>

<p class="font-semibold text-lg">
{{ account.account_number }}
</p>

<p class="text-sm text-gray-500 mt-2">
Balance
</p>

<p class="text-xl font-bold text-green-600">
₹ {{ account.balance }}
</p>

</div>

</div>

</div>

</template>