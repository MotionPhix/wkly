<script setup lang="ts">
import { Modal } from '@inertiaui/modal-vue'

import InputError from '@/Components/InputError.vue'

import TextInput from '@/Components/TextInput.vue';

import { useForm } from '@inertiajs/vue3';

import { DatePicker } from 'v-calendar'

import { UseDark } from '@vueuse/components';

import InputLabel from '@/Components/InputLabel.vue';

import MazSelect from 'maz-ui/components/MazSelect';

import PrimaryButton from '@/Components/PrimaryButton.vue';

import MazTextarea from 'maz-ui/components/MazTextarea'

import MazInput from 'maz-ui/components/MazInput'

import 'v-calendar/style.css'

import { ref } from 'vue';

const props = defineProps<{
  user_id?: number;
  contact_id?: number;
  interaction?: App.Data.InteractionData;
}>();

const modalRef = ref(null);

const form = useForm({
  description: props.interaction?.description || '',
  interaction_type: props.interaction?.interaction_type || '',
  contact_id: props.interaction?.contact_id || props.contact_id,
  location: props.interaction?.location || '',
  event_date: props.interaction?.event_date || '',
  user_id: props.interaction?.user_id || props.user_id
});

const onSubmit = () => {
  if(props.interaction?.id) {

    form.transform((data) => {

      const formData = data;
      formData._method = 'patch'

      return formData

    }).patch(route('interaction.update', props.interaction), {
      onSuccess: () => {
        form.reset();
        modalRef.value.close();
      }
    })

    return
  }

  form.post(route('interaction.store', props.contact_id), {

    onSuccess: () => {

      form.reset();
      modalRef.value.close()

    },

    onError: (error) => {

      console.log(error);

    }

  })
}
</script>

<template>

  <Modal
    class="dark:bg-gray-800"
    :close-button="false"
    v-slot="{ close }"
    ref="modalRef">

    <div
      class="flex items-center justify-between pb-4 border-b rounded-t dark:border-gray-600">
      <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
        {{ interaction?.id ? 'Edit' : 'New' }} interaction
      </h3>

      <button
        type="button"
        @click="close"
        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
        <svg
          class="size-3"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
        </svg>
        <span class="sr-only">Close modal</span>
      </button>
    </div>

    <form
      class="flex flex-col gap-4 pt-2"
      @submit.prevent="onSubmit">

      <div class="max-w-full space-y-3">
        <InputLabel
          for="description">
          Description
        </InputLabel>

        <MazTextarea
          id="description"
          style="border-radius: 08rem !important"
          v-model="form.description"
          placeholder="Enter notes taken from your conversation"
        />
      </div>

      <section class="grid grid-cols-1 gap-4 sm:grid-cols-2">

        <div class="relative">

          <!-- Interaction Type -->
          <InputLabel
            for="interaction_type"
            class="mb-2">
            Interaction type
          </InputLabel>

          <MazSelect
            v-model="form.interaction_type"
            :options="[
              { label: 'Meeting', value: 'meeting' },
              { label: 'Phone Call', value: 'phone call' },
              { label: 'Social Media', value: 'social media' }
            ]"
            option-label-key="label"
            option-value-key="value"
            placeholder="Pick an interaction type"
            rounded-size="md"
            size="lg"
            block
          />

          <div
            class="absolute top-1/2 end-2.5 -translate-y-1/2">
            <svg
              class="text-gray-500 shrink-0 size-4 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m7 15 5 5 5-5"></path>
              <path d="m7 9 5-5 5 5"></path>
            </svg>
          </div>

          <InputError :message="form.errors.interaction_type" />

        </div>

        <!-- Event Date -->
        <div>
          <InputLabel
            for="event_date"
            class="mb-2">
            Event date
          </InputLabel>

          <UseDark v-slot="{ isDark }">

            <DatePicker
              v-model="form.event_date"
              :max-date="new Date()"
              :is-dark="isDark"
              timezone="Zulu"
              @dayclick="
                (_, event) => {
                  event.target.blur();
                }
              ">
              <template
                v-slot="{ inputValue, inputEvents }">
                <MazInput
                  id="event_date"
                  placeholder="Enter event date"
                  :value="inputValue"
                  v-on="inputEvents"
                  rounded-size="md"
                  size="lg"
                  block
                />
              </template>
            </DatePicker>

          </UseDark>

          <InputError :message="form.errors.event_date" />
        </div>

      </section>

      <div>
        <!-- Location -->
        <InputLabel
          for="location"
          class="mb-2">
          Location
        </InputLabel>

        <MazInput
          id="location"
          v-model="form.location"
          placeholder="Where was this?"
          rounded-size="md"
          size="lg"
          block />
      </div>

      <!-- Submit Button -->
      <div class="flex justify-end pt-4">

        <PrimaryButton
          type="submit"
          class="py-2 rounded-md">
          {{ interaction?.id ? 'Update': 'Create' }}
        </PrimaryButton>

      </div>

    </form>

  </Modal>

</template>

<style lang="scss">
.im-modal-content {
  @apply p-4 relative bg-white rounded-lg shadow dark:bg-gray-700 dark:shadow-neutral-700/70 dark:text-gray-200 flex flex-col gap-4;
}

.m-textarea textarea {
  @apply rounded-lg !important;
}
</style>
