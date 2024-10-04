<script setup lang="ts">
import { Modal } from '@inertiaui/modal-vue'
import InputError from '@/Components/InputError.vue'

defineProps<{
  contact: App.ContactData
}>()
</script>

<template>

  <Modal>

    <form>

      <div class="flex flex-col">

        <!-- <label
          for="textarea-label"
          class="block text-sm font-medium mb-2 dark:text-white">
          Describe the interaction
        </label> -->

  <label for="textarea-email-label" class="sr-only">Comment</label>
  <textarea id="textarea-email-label" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" rows="3" placeholder="Say hi...">
        </textarea>

      </div>

      <!-- Interaction Type -->
      <label for="interaction_type">Interaction Type:</label>
      <select id="interaction_type" name="interaction_type">
          <option value="meeting">Meeting</option>
          <option value="phone_call">Phone Call</option>
          <!-- Add other interaction types as needed -->
      </select>

      <!-- Event Date -->
      <label for="event_date">Event Date:</label>
      <input type="date" id="event_date" name="event_date">

      <!-- Location -->
      <label for="location">Location:</label>
      <input type="text" id="location" name="location">

      <!-- Submit Button -->
      <button type="submit">Add Interaction</button>

    </form>

  </Modal>

</template>
