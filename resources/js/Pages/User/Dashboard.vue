<script setup>
import UserLayout from '@/Layouts/UserLayout.vue'

defineOptions({ layout: UserLayout })
defineProps({
  accounts: Array
})
</script>

<template>

<div class="p-6">

<h1 class="text-2xl font-semibold mb-6">
My Dashboard
</h1>


<!-- Accounts -->
<div class="grid md:grid-cols-2 gap-6 mb-8">

<div
v-for="account in accounts"
:key="account.id"
class="bg-white p-6 rounded-xl shadow"
>

<p class="text-sm text-gray-500">
Account Number
</p>

<p class="font-semibold text-lg mb-3">
{{ account.account_number }}
</p>

<p class="text-sm text-gray-500">
Balance
</p>

<p class="text-2xl font-bold text-green-600">
₹ {{ account.balance }}
</p>

</div>

</div>


<!-- Recent Transactions -->

<div class="bg-white rounded-xl shadow">

<div class="p-4 border-b font-semibold">
Recent Transactions
</div>

<table class="w-full text-sm">

<thead class="bg-gray-50">
<tr>
<th class="p-3 text-left">Date</th>
<th class="p-3 text-left">Type</th>
<th class="p-3 text-left">Amount</th>
</tr>
</thead>

<tbody>

<template v-for="account in accounts" :key="account.id">

<tr
v-for="txn in account.transactions || []"
:key="txn.id"
class="border-b"
>

<td class="p-3">
{{ new Date(txn.created_at).toLocaleDateString() }}
</td>

<td class="p-3">

<span
class="px-2 py-1 rounded text-xs"
:class="txn.type === 'credit'
? 'bg-green-100 text-green-700'
: 'bg-red-100 text-red-700'"
>

{{ txn.type }}

</span>

</td>

<td class="p-3">
₹ {{ txn.amount }}
</td>

</tr>

</template>

</tbody>

</table>

</div>

</div>

</template>