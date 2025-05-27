<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { MoveLeft } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Student Edit',
        href: '/students/create',
    },
];

const props = defineProps({
    student: Object,
})

const form = useForm( {
    'name': props.student.name,
    'email': props.student.email,
    'phone': props.student.phone,
    'date_of_birth': props.student.date_of_birth
    ? props.student.date_of_birth.slice(0, 10)
    : '',
    'gender': props.student.gender,
    'course': props.student.course,
})

const handleSubmit = () => {
    form.put(route('students.update', props.student.id), {
        preserveScroll: true,
        onSuccess: () => form.reset()
    })
}

</script>

<template>
    <Head title="Student Edit" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

            <!-- Back Button -->
            <div>
                <Link
                    href="/students"
                    class="inline-flex items-center gap-2 rounded bg-emerald-700 px-4 py-2 text-white transition hover:bg-emerald-800"
                >
                    <MoveLeft class="w-4" />
                    Back
                </Link>
            </div>

            <!-- Responsive Form -->
            <div class="w-full max-w-4xl mx-auto p-4 sm:p-6 bg-gray-50 shadow-md rounded-lg">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-6 text-center sm:text-left">
                    Update Student Information
                </h2>

                <form @submit.prevent="handleSubmit" class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-800">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Name</label>
                        <input
                            id="name"
                            type="text"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 placeholder-gray-500"
                            v-model="form.name"
                            placeholder="Email address"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <!-- Email -->
                    <div class="grid gap-2">
                        <Label for="email">Email address</Label>
                        <input
                            id="email"
                            type="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 placeholder-gray-500"
                            v-model="form.email"
                            placeholder="Email address"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Phone</label>
                        <input
                            type="text"
                            name="phone"
                            placeholder="Enter phone"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 placeholder-gray-500"
                            v-model="form.phone"
                        />
                        <InputError class="mt-2" :message="form.errors.phone" />
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Date of Birth</label>
                        <input
                            type="date"
                            name="date_of_birth"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 text-gray-800"
                            v-model="form.date_of_birth"
                        />
                        <InputError class="mt-2" :message="form.errors.date_of_birth" />
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Gender</label>
                        <select
                            name="gender"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 text-gray-800"
                            v-model="form.gender"
                        >
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.gender" />
                    </div>

                    <!-- Course -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Course</label>
                        <input
                            type="text"
                            name="course"
                            placeholder="Enter course"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 placeholder-gray-500"
                            v-model="form.course"
                        />
                        <InputError class="mt-2" :message="form.errors.course" />
                    </div>

                    <!-- Submit Button -->
                    <div class="sm:col-span-2">
                        <button
                            type="submit"
                            class="w-full bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition"
                            :disabled="form.processing"
                        >
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

