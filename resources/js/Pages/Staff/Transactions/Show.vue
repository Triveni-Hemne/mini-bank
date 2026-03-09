<script setup>
import StaffLayout from '@/Layouts/StaffLayout.vue'
import {Link} from '@inertiajs/vue3'

defineOptions({ layout: StaffLayout })
defineProps({
  transaction: Object
})

</script>

<template>

<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold mb-6">
        Transaction Details
        </h1>
        <Link
            :href="route('staff.transactions.index')"
            class="px-4 py-2 border rounded-lg"
        >
            Back
        </Link>
    </div>

<div class="bg-white rounded-xl shadow p-6 space-y-4">

<p>
<strong>Reference:</strong>
{{ transaction.reference_number }}
</p>

<p>
<strong>Account:</strong>
{{ transaction.account.account_number }}
</p>

<p>
<strong>Customer:</strong>
{{ transaction.account.user.name }}
</p>

<p>
<strong>Type:</strong>
{{ transaction.type }}
</p>

<p>
<strong>Amount:</strong>
₹ {{ transaction.amount }}
</p>

<p>
<strong>Date:</strong>
{{ new Date(transaction.created_at).toLocaleString() }}
</p>

</div>

    </div>

    </template>