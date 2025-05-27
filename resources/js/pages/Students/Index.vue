<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Plus, Pencil, Trash2 } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Students',
        href: '/students',
    },
];

const props = defineProps({
    students: Array,
});

const form = useForm();

const handleDelete = (id) => {
    if (confirm('Are you sure you want to delete this student?')) {
        form.delete(route('students.destroy', id), {
            preserveScroll: true,
        });
    }
};

const toggleStatus = (student) => {
    const newStatus = !student.status;

    const updateForm = useForm({
        status: newStatus
    });

    updateForm.patch(route('students.update-status', student.id), {
        preserveScroll: true,
        onSuccess: () => {
            student.status = newStatus;
            updateForm.reset();
        },
        onError: (errors) => {
            console.error('Error updating student status:', errors);
        }
    });
};

const formatDate = (dateStr) => {
    // return new Date(dateStr).toLocaleDateString();
    return dateStr.slice(0, 10);
}
</script>

<template>
    <Head title="Students" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="p-6">
                <div class="flex justify-between mb-6">
                    <h1 class="text-2xl font-semibold">Students List</h1>
                    <div>
                        <Link href="/students/create" class="inline-flex items-center gap-2 rounded bg-blue-600 px-4 py-2 text-white transition hover:bg-blue-700">
                            <Plus />
                            Create Student
                        </Link>
                    </div>

                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 rounded-lg border shadow">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-md font-bold text-black">ID</th>
                                <th class="px-6 py-3 text-left text-md font-bold text-black">Name</th>
                                <th class="px-6 py-3 text-left text-md font-bold text-black">Email</th>
                                <th class="px-6 py-3 text-left text-md font-bold text-black">Phone</th>
                                <th class="px-6 py-3 text-left text-md font-bold text-black">DOB</th>
                                <th class="px-6 py-3 text-left text-md font-bold text-black">Gender</th>
                                <th class="px-6 py-3 text-left text-md font-bold text-black">Course</th>
                                <th class="px-6 py-3 text-left text-md font-bold text-black">Status</th>
                                <th class="px-6 py-3 text-left text-md font-bold text-black">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-for="(student, index) in students" :key="index">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ student.id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ student.name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ student.email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ student.phone }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ formatDate(student.date_of_birth) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 capitalize">{{ student.gender }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ student.course }}</td>
                                <td  class="px-6 py-4">
                                    <label class="inline-flex cursor-pointer items-center">
                                        <input
                                            type="checkbox"
                                            v-model="student.status"
                                            class="peer sr-only"
                                            :checked="student.status"
                                            @click="toggleStatus(student)"
                                        />
                                        <div
                                            class="relative h-6 w-11 rounded-full transition-colors duration-300"
                                            :class="student.status ? 'bg-green-600' : 'bg-red-600' "
                                        >
                                            <div
                                                class="absolute top-1 h-4 w-4 rounded-full bg-white transition-transform duration-300"
                                                :class="student.status ? 'right-1' : 'left-1' "
                                            ></div>
                                        </div>
                                    </label>
                                </td>

                                <td class="space-x-2 px-6 py-4 text-sm text-gray-800">
                                    <Link :href="`students/${student.id}/edit`" class="inline-flex items-center gap-2 rounded bg-blue-600 px-4 py-2 text-white transition hover:bg-blue-700">
                                        <Pencil class="w-4" />
                                        Edit
                                    </Link>
                                    <button @click="handleDelete(student.id)" class="cursor-pointer inline-flex items-center gap-2 rounded bg-red-600 px-4 py-2 text-white transition hover:bg-red-700">
                                        <Trash2 class="w-4" />
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
