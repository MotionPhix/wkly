<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import DeleteUserForm from "./Partials/DeleteUserForm.vue"
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue"
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue"
import { Head } from "@inertiajs/vue3"
import useStickyTop from "@/Composables/useStickyTop"

defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
})

const { navClasses } = useStickyTop()

defineOptions({
  layout: AuthenticatedLayout
})
</script>

<template>
  <Head title="Profile" />

  <nav
    class="flex items-center h-16 max-w-3xl gap-6 px-8 mx-auto print:hidden dark:text-white dark:border-gray-700"
    :class="navClasses"
  >
    <h2
      class="flex items-center gap-2 text-xl font-semibold leading-tight text-gray-900 dark:text-white"
    >
      <span>My profile</span>
    </h2>
  </nav>

  <div class="py-12">
    <div class="max-w-3xl mx-auto space-y-6 sm:px-6 lg:px-8">
      <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
        <UpdateProfileInformationForm
          :must-verify-email="mustVerifyEmail"
          :status="status"
          class="w-full"
        />
      </div>

      <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
        <UpdatePasswordForm class="max-w-full" />
      </div>

      <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
        <DeleteUserForm class="max-w-full" />
      </div>
    </div>
  </div>
</template>
