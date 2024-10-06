<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import {
  IconAddressBook,
  IconTrash,
  IconPencil,
  IconPlus
} from '@tabler/icons-vue';
import { ModalLink } from '@inertiaui/modal-vue'
import { ref, onMounted } from 'vue';
import { gsap } from 'gsap'

defineProps<{
  interactions: App.Data.InteractionData[],
  contactId: string,
}>()

/*const icons = ref(null);

// GSAP animations
const animateIn = () => {
  gsap.to(icons.value, { autoAlpha: 1, x: 0, duration: 0.2, display: 'flex' });
};

const animateOut = () => {
  gsap.to(icons.value, { autoAlpha: 0, x: 20, duration: 0.2, display: 'none' });
};

onMounted(() => {
  // Initially hide icons
  gsap.set(icons.value, { autoAlpha: 0, x: 20 });
});*/

// Create an object to store refs for each row's icons
const iconRefs = ref<Record<number, HTMLElement | null>>({});

// Function to set the icons ref for each row dynamically
const setIconRef = (id: number) => (el: HTMLElement | null) => {
  iconRefs.value[id] = el;
};

// GSAP animations
const animateIn = (event: Event, id: number) => {
  const icons = iconRefs.value[id];
  if (icons) {
    gsap.to(icons, { autoAlpha: 1, y: 0, duration: 0.2, display: 'flex' });
  }
};

const animateOut = (event: Event, id: number) => {
  const icons = iconRefs.value[id];
  if (icons) {
    gsap.to(icons, { autoAlpha: 0, y: 10, duration: 0.2, display: 'none' });
  }
};

onMounted(() => {
  // Initially hide all icons
  Object.values(iconRefs.value).forEach(icons => {
    if (icons) {
      gsap.set(icons, { autoAlpha: 0, y: 10 });
    }
  });
});
</script>

<template>
  <div
    v-if="interactions.length"
    class="my-12 overflow-hidden rounded-lg shadow dark:bg-gray-800">

    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">

      <thead>
        <tr>
          <th class="px-6 py-3 text-lg font-medium tracking-wider text-left text-gray-500 uppercase dark:text-neutral-500">Date</th>

          <th
            class="flex items-center justify-between w-full px-6 py-3 text-lg font-medium tracking-wider text-left text-gray-500 uppercase dark:text-neutral-500">

            <span>
              Description
            </span>

            <ModalLink
              as="button"
              class="flex items-center gap-2 px-2 py-1 font-semibold text-gray-500 transition duration-300 border border-gray-500 rounded-md hover:border-gray-900 dark:border-slate-600 dark:text-gray-500 dark:hover:text-gray-400 dark:hover:border-gray-400 hover:text-gray-900"
              :href="route('interaction.create', contactId)" preserve-scroll>

              <IconPlus class="size-5" />
              <span>New</span>

            </ModalLink>
          </th>
        </tr>
      </thead>

      <tbody
        class="divide-y divide-gray-200 dark:divide-neutral-700 dark:text-neutral-200">
        <tr v-for="interaction in interactions">
          <td
            class="px-6 py-4 prose align-top dark:prose-invert whitespace-nowrap">
            {{ interaction.display_event_date }}
          </td>

          <td
            class="px-6 py-4"
            @mouseenter="(e) => animateIn(e, interaction.id)"
            @mouseleave="(e) => animateOut(e, interaction.id)">

            <!-- @mouseenter="animateIn" @mouseleave="animateOut" -->

            <div
              class="flex justify-between capitalize">
              <strong class="prose prose-lg dark:prose-invert">
                {{ interaction.interaction_type }}
              </strong>

              <div
                class="items-center hidden gap-2"
                :ref="setIconRef(interaction.id)">
                <ModalLink
                  as="button"
                  :href="route('interaction.edit', interaction)">
                  <IconPencil class="size-5" />
                </ModalLink>

                <Link
                  as="button"
                  method="delete"
                  preserve-scroll
                  :href="route('interaction.destroy', interaction)">
                  <IconTrash class="size-5" />
                </Link>
              </div>
            </div>

            <div
              class="prose dark:prose-invert"
              v-html="interaction.description" />

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
        class="flex items-center gap-2 px-4 py-3 my-4 font-semibold text-gray-500 transition duration-300 border border-gray-500 rounded-md hover:border-gray-900 dark:border-slate-600 dark:text-gray-500 dark:hover:text-gray-400 dark:hover:border-gray-400 hover:text-gray-900"
        :href="route('interaction.create', contactId)" preserve-scroll>

        <IconPlus class="size-5" />
        <span>Add interaction</span>

      </ModalLink>

    </div>

  </div>
</template>
