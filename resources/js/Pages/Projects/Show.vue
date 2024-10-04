<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { IconArrowLeft, IconClockUp, IconClockDown, IconTrash, IconDots } from '@tabler/icons-vue'
import { computed } from "vue"
import ProjectNameForm from '@/Pages/Projects/ProjectNameForm.vue'
import useStickyTop from "@/Composables/useStickyTop"
import BoardList from '@/Pages/Projects/Boards/BoardList.vue'
import { useProjectStore } from '@/Stores/projectStore'
import { storeToRefs } from 'pinia'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'

const projectStore = useProjectStore()

const { project } = storeToRefs(projectStore)

defineOptions({
  layout: AuthenticatedLayout,
})

const title = computed(
  () => project.value.contact?.firm?.name ?? `${project.value.contact.first_name} ${project.value.contact.last_name}`
)

const { navClasses } = useStickyTop();

</script>

<template>
  <Head :title="title" />

  <nav
    class="flex items-center w-full h-16 max-w-3xl gap-6 px-8 mx-auto dark:text-white dark:border-gray-700"
    :class="navClasses">

    <Link
      :href="route('projects.index')"
      as="button"
      preserve-state
      preserve-scroll>
      <IconArrowLeft class="h-7" stroke="2.5" />
    </Link>

    <h3 class="text-2xl font-display">
      {{ `${project.contact.first_name} ${project.contact.last_name}'s project.` }}
    </h3>

    <span class="flex-1"></span>

    <Link
      method="delete"
      :href="route('projects.destroy', { ids: project.pid })"
      class="flex items-center gap-2 duration-200 hover:opacity-75"
      preserve-scroll
      as="button">
      <IconTrash class="h-5" />
      <span>Delete</span>
    </Link>

  </nav>

  <section class="flex flex-col max-w-3xl px-8 pt-12 mx-auto">

    <div
      class="relative flex-none overflow-hidden bg-gray-300 h-80 dark:bg-gray-700 rounded-xl">

      <Menu
        as="div"
        class="absolute top-0 z-10 right-5">

        <MenuButton
          class="h-10 font-semibold dark:border-gray-700 dark:text-slate-300 border-slate-200 text-slate-900">

          <IconDots class="size-6" />

        </MenuButton>

        <transition
          enter-active-class="transition duration-100 ease-out transform"
          enter-from-class="scale-90 opacity-0"
          enter-to-class="scale-100 opacity-100"
          leave-active-class="transition duration-100 ease-in transform"
          leave-from-class="scale-100 opacity-100"
          leave-to-class="scale-90 opacity-0">

          <MenuItems
            class="absolute right-0 w-40 overflow-hidden origin-top-left bg-white border rounded-md shadow-lg top-10 dark:text-gray-300 dark:bg-gray-800 dark:border-gray-700 focus:outline-none">

            <MenuItem>

              <button
                type="button"
                class="flex items-center w-full gap-2 px-4 py-2 text-sm dark:hover:bg-gray-600">
                <span>Upload poster</span>
              </button>

            </MenuItem>

            <MenuItem>

              <button
                type="button"
                class="flex items-center w-full gap-2 px-4 py-2 text-sm dark:hover:bg-gray-600">

                <span>Upload files</span>

              </button>

            </MenuItem>

            <MenuItem>

              <button
                type="button"
                class="flex items-center w-full gap-2 px-4 py-2 text-sm dark:hover:bg-gray-600">

                <span>Delete</span>

              </button>

            </MenuItem>

          </MenuItems>

        </transition>

      </Menu>

      <img src="https://picsum.photos/536/354" alt="Project poster" class="object-cover w-full">

    </div>

    <div
      class="relative flex flex-col">

      <div class="flex-auto p-6">

        <div class="flex flex-wrap">

          <h1 class="flex-auto font-light text-slate-900 dark:text-slate-200">
            {{ `${project.contact.first_name} ${project.contact.last_name}` }}
          </h1>

          <div
            class="flex-none order-1 w-full text-lg font-bold text-lime-600"
            v-if="project.contact.firm">
            {{ project.contact.firm.name }}
          </div>

          <div class="text-sm font-medium text-slate-400">
            {{ project.contact.emails[0].email }}
          </div>
        </div>

      </div>

    </div>

    <div class="mb-12 space-y-6">

      <ProjectNameForm />

      <hr class="border-gray-300 dark:border-gray-700">

      <section
        v-html="project.description"
        class="pt-8 prose dark:prose-invert empty:hidden"
        v-if="project.description" />
    </div>

    <section
      class="grid grid-cols-1 gap-4 dark:text-white md:grid-cols-2 font-display">

      <div
        class="p-4 space-y-2 border border-gray-400 rounded-md dark:border-gray-700">

        <p class="font-semibold">
          Start date
        </p>

        <p class="flex items-center gap-2">
          <IconClockUp class="h-6" />

          <span>
            {{ project.created_at }}
          </span>
        </p>
      </div>

      <div class="p-4 space-y-2 border border-gray-400 rounded-md dark:border-gray-700">
        <p class="font-semibold">
          Due date
        </p>

        <p class="flex items-center gap-2">
          <IconClockDown class="h-6" />

          <div class="flex flex-col">
            <span>
              {{ project.due_date }}
            </span>

            <span class="font-sans text-xs text-gray-400 dark:text-gray-500">
              Deadline {{ project.deadline.includes('now') ? 'is' : 'was'}} {{ project.deadline }}.
            </span>
          </div>
        </p>
      </div>
    </section>

  </section>

  <section>

    <!-- start -->
    <div class="flex flex-col max-w-3xl gap-24 px-6 py-12 mx-auto">

      <h2
        class="text-3xl dark:text-gray-400 font-display">
        Tasks
      </h2>

    </div>

    <template v-if="project.pid">

      <BoardList />

    </template>

  </section>

</template>
