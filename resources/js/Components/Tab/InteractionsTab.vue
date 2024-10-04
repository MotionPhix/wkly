<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import { IconAddressBook, IconPlus } from '@tabler/icons-vue';
import { ModalLink } from '@inertiaui/modal-vue'

defineProps<{
  interactions: App.Data.InteractionData[],
  contactId: string,
}>()
</script>

<template>
  <div
    v-if="interactions.length"
    class="overflow-hidden bg-white rounded-lg shadow">

    <table class="min-w-full divide-y divide-gray-200">

      <thead class="bg-gray-100">
        <tr>
          <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Date</th>
          <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Type</th>
          <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Description</th>
        </tr>
      </thead>

      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="interaction in interactions">
          <td
            class="px-6 py-4 whitespace-nowrap">
            {{ interaction.event_date }}
          </td>

          <td class="px-6 py-4">
            {{ interaction.interaction_type }}
          </td>

          <td class="px-6 py-4">
            {{ interaction.description }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div
    v-else
    class="flex flex-col items-center gap-3 text-gray-500 empty:hidden">
    <IconAddressBook class="w-48 h-48 text-gray-400" stroke-width="1" />

    <h2 class="mt-6 text-xl font-semibold leading-none text-center">
      No interactions found!
    </h2>

    <p class="text-sm text-center">
      Start interacting.
    </p>

    <div>

      <ModalLink
        as="button"
        class="flex gap-2 items-center text-gray-500 border-gray-500 border hover:border-gray-900 rounded-lg dark:border-slate-600 dark:text-gray-500 font-semibold my-4 px-3 py-1.5 dark:hover:text-gray-400 dark:hover:border-gray-400 hover:text-gray-900 transition duration-300"
        :href="route('interaction.create', contactId)" preserve-scroll>

        <IconPlus class="w-5 h-5" />
        <span>Add interaction</span>

      </ModalLink>
    </div>
  </div>
</template>
