<script setup>
import StaffLayout from '@/Layouts/StaffLayout.vue'
import { Link } from '@inertiajs/vue3'

defineOptions({ layout: StaffLayout })
defineProps({
  transactions: Object
})
</script>

<template>
<div class="p-6 space-y-6">

<!-- Header -->
<div class="flex items-center justify-between">
<h1 class="text-2xl font-semibold text-gray-800">
Transactions
</h1>

<Link
:href="route('staff.accounts.index')"
class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700"
>
View Accounts
</Link>

</div>


<!-- Filters -->
<div class="bg-white shadow rounded-xl p-4 flex gap-4 items-center">

<input
type="text"
placeholder="Search account or reference..."
class="border rounded-lg px-3 py-2 w-64"
/>

<select class="border rounded-lg px-3 py-2">
<option value="">All Types</option>
<option value="credit">Deposit</option>
<option value="debit">Withdrawal</option>
</select>

<select class="border rounded-lg px-3 py-2">
<option value="">Latest</option>
<option value="oldest">Oldest</option>
</select>

</div>


<!-- Table -->
<div class="bg-white shadow rounded-xl overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-gray-50 border-b text-gray-600">
<tr>
<th class="p-4 text-left">Reference</th>
<th class="p-4 text-left">Account</th>
<th class="p-4 text-left">Customer</th>
<th class="p-4 text-left">Type</th>
<th class="p-4 text-left">Amount</th>
<th class="p-4 text-left">Date</th>
<th class="p-4 text-right">Action</th>
</tr>
</thead>


<tbody>

<tr
v-for="tx in transactions.data"
:key="tx.id"
class="border-b hover:bg-gray-50 transition"
>

<!-- Reference -->
<td class="p-4 font-medium text-gray-700">
{{ tx.reference_number }}
</td>


<!-- Account -->
<td class="p-4 text-gray-600">
{{ tx.account.account_number }}
</td>


<!-- Customer -->
<td class="p-4 text-gray-700">
{{ tx.account.user.name }}
</td>


<!-- Type -->
<td class="p-4">

<span
v-if="tx.type === 'credit'"
class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full"
>
Deposit
</span>

<span
v-else
class="bg-red-100 text-red-700 text-xs px-3 py-1 rounded-full"
>
Withdrawal
</span>

</td>


<!-- Amount -->
<td class="p-4 font-semibold">

<span v-if="tx.type === 'credit'" class="text-green-600">
+ ₹{{ tx.amount }}
</span>

<span v-else class="text-red-600">
- ₹{{ tx.amount }}
</span>

</td>


<!-- Date -->
<td class="p-4 text-gray-500">
{{ new Date(tx.created_at).toLocaleString() }}
</td>


<!-- Action -->
<td class="p-4 text-right">

<Link
:href="route('staff.transactions.show', tx.id)"
class="text-indigo-600 hover:underline text-sm"
>
View
</Link>

</td>

</tr>


<!-- Empty -->
<tr v-if="transactions.data.length === 0">
<td colspan="7" class="p-6 text-center text-gray-500">
No transactions found
</td>
</tr>

</tbody>

</table>

</div>


<!-- Pagination -->
<div class="flex justify-between items-center">

<p class="text-sm text-gray-500">
Showing {{ transactions.from }} to {{ transactions.to }} of {{ transactions.total }}
</p>

<div class="flex gap-2">

<Link
v-if="transactions.prev_page_url"
:href="transactions.prev_page_url"
class="px-3 py-1 border rounded"
>
Prev
</Link>

<Link
v-if="transactions.next_page_url"
:href="transactions.next_page_url"
class="px-3 py-1 border rounded"
>
Next
</Link>

</div>

</div>


</div>
</template>