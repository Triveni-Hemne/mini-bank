<script setup>
import StaffLayout from '@/Layouts/StaffLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { reactive } from 'vue'

defineOptions({ layout: StaffLayout })

const props = defineProps({
  account: Object,
  statement: Array,
  opening_balance: Number,
  filters: Object
})

const filters = reactive({
  from: props.filters?.from || '',
  to: props.filters?.to || ''
})

function applyFilter() {
  router.get(
    route('staff.accounts.statement', props.account.id),
    filters,
    { preserveState: true }
  )
}
</script>

<template>

<div class="p-6">

<!-- Header -->
<div class="flex justify-between items-center mb-6">
<h1 class="text-2xl font-semibold">
Account Statement
</h1>

<Link
:href="route('staff.accounts.show', account.id)"
class="text-blue-600"
>
Back to Account
</Link>
</div>


<!-- Account Info -->
<div class="bg-white rounded-xl shadow p-6 mb-6">

<p><strong>Account:</strong> {{ account.account_number }}</p>
<p><strong>Customer:</strong> {{ account.user.name }}</p>
<p><strong>Current Balance:</strong> ₹ {{ account.balance }}</p>

</div>


<!-- Filters -->
<div class="bg-white rounded-xl shadow p-6 mb-6">

<div class="flex gap-4 items-end">

<div>
<label class="block text-sm mb-1">From</label>
<input
v-model="filters.from"
type="date"
class="border rounded p-2"
/>
</div>

<div>
<label class="block text-sm mb-1">To</label>
<input
v-model="filters.to"
type="date"
class="border rounded p-2"
/>
</div>

<button
@click="applyFilter"
class="bg-blue-600 text-white px-4 py-2 rounded"
>
Filter
</button>

</div>

</div>


<!-- Statement Table -->
<div class="bg-white rounded-xl shadow overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-gray-50 border-b">

<tr>

<th class="p-3 text-left">Date</th>
<th class="p-3 text-left">Type</th>
<th class="p-3 text-left">Description</th>
<th class="p-3 text-left">Reference</th>
<th class="p-3 text-right">Debit</th>
<th class="p-3 text-right">Credit</th>
<th class="p-3 text-right">Balance</th>

</tr>

</thead>

<tbody>

<!-- Opening Balance -->

<tr class="bg-gray-50 font-medium">

<td class="p-3">Opening Balance</td>
<td class="p-3"></td>
<td class="p-3"></td>
<td class="p-3"></td>
<td class="p-3"></td>
<td class="p-3"></td>

<td class="p-3 text-right">
₹ {{ opening_balance }}
</td>

</tr>


<!-- Transactions -->

<tr
v-for="(txn, index) in statement"
:key="index"
class="border-b hover:bg-gray-50"
>

<td class="p-3">{{ txn.date }}</td>

<td class="p-3">

<span
class="px-2 py-1 text-xs rounded"
:class="txn.type === 'credit'
? 'bg-green-100 text-green-700'
: 'bg-red-100 text-red-700'"
>

{{ txn.type }}

</span>

</td>

<td class="p-3">
{{ txn.description }}
</td>

<td class="p-3">
{{ txn.reference_no }}
</td>

<td class="p-3 text-right">
<span v-if="txn.type === 'debit'">
₹ {{ txn.amount }}
</span>
</td>

<td class="p-3 text-right">
<span v-if="txn.type === 'credit'">
₹ {{ txn.amount }}
</span>
</td>

<td class="p-3 text-right font-medium">
₹ {{ txn.balance }}
</td>

</tr>

<!-- Empty -->

<tr v-if="statement.length === 0">

<td colspan="7" class="p-6 text-center text-gray-500">
No transactions found
</td>

</tr>

</tbody>

</table>

</div>

</div>

</template>