<script setup lang="ts">
import { useProjectStore } from '@/Stores/projectStore';
import { Link, router } from '@inertiajs/vue3';
import { IconTrash } from '@tabler/icons-vue';
import axios from 'axios';


const props = defineProps<{
  project: App.Data.ProjectData
}>()

const projectStore = useProjectStore()

const { setProject } = projectStore

const fetchProject = () => {

  axios
    .get(route('projects.show', { project: props.project.pid }))
    .then((resp) => {

      setProject(resp.data)

      setTimeout(() => {

        router.get(route('projects.show', { project: props.project.pid }))

      }, 50)

    })
    .catch((err) => {

      console.log(err);

    })

}

</script>

<template>
<div
  class="relative flex flex-col p-4 overflow-hidden bg-white rounded-lg shadow gap-y-3 lg:gap-y-5 md:p-5 dark:bg-gray-800 group">

  <div class="inline-flex items-center gap-2">

    <img
        class="rounded-full size-8"
        :src="props.project.author.avatar_url"
        alt="notices.data.user.name"
      />

    <span class="font-semibold text-gray-600 dark:text-neutral-400">
      {{ props.project.author.name }}
    </span>

  </div>

  <button
    @click="fetchProject"
    class="block text-xl font-light text-left text-gray-800 dark:text-neutral-200">
    <div class="line-clamp-3">

      {{ props.project.name }}

    </div>
  </button>

  <div class="flex flex-col justify-end flex-1 gap-2 divide-y divide-gray-200 dark:divide-gray-700">

    <div>
      <span class="block text-xs dark:text-gray-600">
        Due by
      </span>

      <span class="block text-sm text-gray-500 dark:text-neutral-500">
        {{ props.project.due_date }}
      </span>
    </div>

    <div class="pt-2 text-start">
      <span class="block text-xs dark:text-gray-600">
        Project for
      </span>

      <span class="block text-sm font-semibold text-gray-500 dark:text-neutral-500">
        {{ props.project.contact?.firm?.name ?? `${project.contact.first_name} ${project.contact.last_name}` }}
      </span>
    </div>

  </div>

  <div
    class="absolute items-center justify-center hidden w-12 h-12 transition duration-300 bg-gray-300 rounded-md -bottom-2 -right-2 dark:bg-gray-600 group-hover:flex">

    <Link
      :href="route('projects.destroy', { ids: project.pid })"
      class="relative flex items-center justify-center text-gray-800 transition duration-300 -left-1 -top-1 hover:text-rose-500"
      method="delete"
      preserve-scroll
      as="button">

      <IconTrash class="w-6 h-6 align-bottom" />

    </Link>

  </div>

</div>

</template>
