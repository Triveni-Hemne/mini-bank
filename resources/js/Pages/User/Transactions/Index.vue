<script setup>
import UserLayout from '@/Layouts/UserLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
  transactions: Object
})

defineOptions({
  layout: UserLayout
})
</script>

<template>

<div>

<h1 class="text-2xl font-semibold mb-6">
Transaction History
</h1>

<div class="bg-white rounded-xl shadow overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-gray-50 border-b">
<tr>

<th class="p-3 text-left">Date</th>
<th class="p-3 text-left">Account</th>
<th class="p-3 text-left">Type</th>
<th class="p-3 text-left">Reference</th>
<th class="p-3 text-right">Amount</th>

</tr>
</thead>

<tbody>

<tr
v-for="txn in transactions.data"
:key="txn.id"
class="border-b hover:bg-gray-50"
>

<td class="p-3">
{{ new Date(txn.created_at).toLocaleDateString() }}
</td>

<td class="p-3">
{{ txn.account.account_number }}
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
{{ txn.reference_number }}
</td>

<td class="p-3 text-right font-medium">
₹ {{ txn.amount }}
</td>

</tr>

<tr v-if="transactions.data.length === 0">
<td colspan="5" class="p-6 text-center text-gray-500">
No transactions found
</td>
</tr>

</tbody>

</table>

</div>

<!-- Pagination -->

<div class="mt-6 flex gap-2">

<Link
v-for="link in transactions.links"
:key="link.label"
:href="link.url || ''"
v-html="link.label"
class="px-3 py-1 border rounded"
:class="{ 'bg-gray-200': link.active }"
/>

</div>

</div>

</template>