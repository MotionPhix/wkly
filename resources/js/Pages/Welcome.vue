<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { Head, Link } from '@inertiajs/vue3';
import { IconMenu } from '@tabler/icons-vue';
import AppLayout from '../Layouts/AppLayout.vue';

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
})

defineOptions({
  layout: AppLayout
})
</script>

<template>

  <Head title="Get Started" />

  <header class="container px-4 mx-auto">
        <nav class="flex items-center justify-between py-4">
            <div class="text-lg font-bold">WeekDay</div>
            <div class="hidden space-x-4 md:flex">
                <a href="#" class="hover:text-purple-500">Home</a>
                <a href="#" class="hover:text-purple-500">Unlimited Debit</a>
                <a href="#" class="hover:text-purple-500">Merchants</a>
                <a href="#" class="hover:text-purple-500">Login</a>
            </div>
            <!-- Mobile Menu -->
            <div class="md:hidden">Menu</div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container px-4 mx-auto">
        <section class="py-12 text-center">
            <h1 class="mb-4 text-3xl font-bold">Simplify work and get more done with us</h1>
            <p class="mb-4 text-lg">Plan and manage any type of work with project management tools that flexes to your team's needs</p>
            <button class="px-4 py-2 text-white transition bg-purple-600 rounded hover:bg-purple-700">Start Your 14 Days Free Trial</button>
        </section>

        <!-- Tools Advantage -->
        <section class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-3">
            <div class="p-4 bg-white rounded shadow dark:bg-gray-800">
                <h2 class="font-semibold">Easy to manage</h2>
                <p>Manage your tasks with ease and collaborate efficiently.</p>
            </div>
            <!-- Repeat for other advantages -->
        </section>

        <!-- Pricing Plans -->
        <section class="mb-12">
            <h2 class="mb-4 text-2xl font-bold text-center">The best work solution</h2>
            <div class="flex flex-wrap justify-center gap-4">
                <!-- Pricing Card -->
                <div class="p-4 bg-white rounded shadow dark:bg-gray-800">
                    <h3 class="text-lg font-semibold">$40 / Month</h3>
                    <ul>
                        <li>100 MB Storage</li>
                        <li>Unlimited Task</li>
                    </ul>
                </div>
                <!-- Repeat for other plans -->
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-4 text-sm text-center">
            <p>© 2020 - 2022 Feat Boulevard. All rights reserved.</p>
        </footer>
    </main>

</template>
