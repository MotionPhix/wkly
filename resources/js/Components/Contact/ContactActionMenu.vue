<script setup lang="ts">
import IconContactAdd from '@/Components/Icon/IconContactAdd.vue';
import useStickyTop from '@/Composables/useStickyTop';
import { useContactStore } from '@/Stores/contactStore';
import { Link } from '@inertiajs/vue3';
import { IconPencil, IconTrash } from '@tabler/icons-vue';
import { storeToRefs } from 'pinia';

const props = defineProps<{
  contacts: App.Data.ContactData[]
}>()

const contactStore = useContactStore()

const { navClasses } = useStickyTop()

const {
  selectedContacts
} = storeToRefs(contactStore)
</script>

<template>
  <nav
    class="flex items-center h-16 max-w-3xl px-8 mx-auto print:hidden dark:text-white dark:border-gray-700"
    :class="navClasses">

    <div
      v-if="!selectedContacts.length">

      <Link
        as="button"
        v-if="props.contacts.length"
        :href="route('contacts.create')"
        class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70">
        <IconContactAdd
          class="stroke-current size-5" />
        <span>New contact</span>
      </Link>

      <h2 v-else class="text-xl font-semibold">
        Explore Contacts
      </h2>

    </div>

    <div
      v-if="selectedContacts.length && Object.keys(props.contacts).length"
      class="flex items-center w-full gap-6">

      <Link
        as="button"
        :href="route('contacts.edit', selectedContacts[0])"
        v-if="selectedContacts.length === 1 && $page.url === '/contacts'"
        class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70">
        <IconPencil
          class="stroke-current size-5" />
          <span class="hidden sm:inline-flex">Edit</span>
      </Link>

      <Link
        as="button"
        method="delete"
        :href="route('contacts.destroy', { ids: selectedContacts } as any)"
        class="flex items-center gap-2 font-semibold transition duration-300 hover:opacity-70">
        <IconTrash
          class="stroke-current size-5" />
          <span class="hidden sm:inline-flex">Delete</span>
      </Link>

    </div>

  </nav>

</template>
