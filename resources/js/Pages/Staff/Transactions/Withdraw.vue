<script setup>
import { useForm } from '@inertiajs/vue3'
import StaffLayout from '@/Layouts/StaffLayout.vue'

defineOptions({ layout: StaffLayout })
const props = defineProps({
  account: Object
})

const form = useForm({
  amount: ''
})

function submit() {
  form.post(route('staff.transactions.withdraw', props.account.id))
}
</script>

<template>
<div class="p-6">

<h1 class="text-2xl font-semibold mb-6">
Withdraw Money
</h1>

<div class="bg-white p-6 rounded-xl shadow max-w-lg">

<p class="mb-2">
<strong>Account:</strong> {{ account.account_number }}
</p>

<p class="mb-2">
<strong>Customer:</strong> {{ account.user.name }}
</p>

<p class="mb-4 text-red-600">
<strong>Balance:</strong> ₹ {{ account.balance }}
</p>

<form @submit.prevent="submit" class="space-y-4">

<div>
<label class="block mb-1">Amount</label>
<input
v-model="form.amount"
type="number"
class="w-full border rounded p-2"
/>
</div>

<button
class="bg-red-600 text-white px-4 py-2 rounded"
>
Withdraw
</button>

</form>

</div>

</div>
</template>