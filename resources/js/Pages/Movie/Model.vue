<template>
  <div>
    <!-- Main Modal -->
    <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-start overflow-y-auto">
      <!-- Modal Container -->
      <div class="relative bg-white rounded-lg shadow-lg w-full max-w-md mt-10 mb-10">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-5 border-b">
          <h3 class="text-lg font-semibold text-gray-900">
            Add Movie
          </h3>
          <button class="text-gray-400 hover:text-gray-900" @click="$emit('closeModel')">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="18" y1="6" x2="6" y2="18" />
              <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
          </button>
        </div>
        <!-- Modal Body -->
        <div class="p-4">
          <form @submit.prevent="saveMovie">
            <!-- Movie Name -->
            <div class="mb-4">
              <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Movie Name</label>
              <input type="text" id="name" v-model="form.name" placeholder="Enter movie name"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
              <div v-if="localerrors.name" class="text-sm text-red-500 mt-2 pl-2">
                {{ localerrors.name }}
              </div>
            </div>
            <!-- Director Field -->
            <div class="mb-4">
              <label for="director" class="block text-sm font-medium text-gray-700 mb-2">Director</label>
              <select id="director" v-model="form.director"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <option value="">Select Director</option>
                <option value="Sagar Ambre">Sagar Ambre</option>
                <option value="Pushkar Ojha">Pushkar Ojha</option>
              </select>
              <div v-if="localerrors.name" class="text-sm text-red-500 mt-2 pl-2">
                {{ localerrors.director }}
              </div>
            </div>
            <!-- Release Date -->
            <div class="mb-4">
              <label for="release_date" class="block text-sm font-medium text-gray-700 mb-2">Release Date</label>
              <input type="date" v-model="form.release_date"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
              <div v-if="localerrors.release_date" class="text-sm text-red-500 mt-2 pl-2">
                {{ localerrors.release_date }}
              </div>
            </div>
            <!-- Phone Number -->
            <div class="mb-4">
              <label for="number" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
              <input type="number" id="number" v-model="form.number"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
              <div v-if="localerrors.number" class="text-sm text-red-500 mt-2 pl-2">
                {{ localerrors.number }}
              </div>
            </div>
            <!-- Phone Number -->
            <div class="mb-4">
              <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price</label>
              <input type="number" v-model="form.price"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
              <div v-if="localerrors.price" class="text-sm text-red-500 mt-2 pl-2">
                {{ localerrors.price }}
              </div>
            </div>
            <!-- image  -->

            <!-- File Input -->
            <div class="mb-4">
              <label for="file-upload" class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Select
                Image</label>
              <div class="flex items-center justify-center w-full">
                <label for="file-upload"
                  class="cursor-pointer flex flex-col items-center justify-center w-full h-20 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100">
                  <span class="text-gray-500 text-sm">Click to upload or drag and drop</span>
                  <input id="file-upload" type="file" class="hidden" @change="previewImage" />
                </label>
              </div>
              <!-- Preview Selected Images -->
              <div>
                <samp v-if="!form.image"> </samp>
                <img v-else :src="previewUrls" alt="Preview"
                  style="width: 150px; height: auto; margin: 10px 0; border-radius: 8px; border: 1px solid #ccc;">
              </div>
            </div>
            <div v-if="localerrors.image" class="text-sm text-red-500 mt-2 pl-2">
              {{ localerrors.image }}
            </div>

            <!-- text -->
            <div class="mb-4">
              <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                message</label>
              <textarea id="message" rows="4" v-model="form.description"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Write your thoughts here..."></textarea>
              <div v-if="localerrors.description" class="text-sm text-red-500 mt-2 pl-2">
                {{ localerrors.description }}
              </div>
            </div>
            <!-- States -->
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
              <div class="flex space-x-4">
                <div class="flex items-center">
                  <input type="radio" value=1 v-model="form.status"
                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
                  <label for="activa" class="ml-2 text-sm text-gray-800">Activa</label>
                </div>
                <div class="flex items-center">
                  <input type="radio" value=0 v-model="form.status"
                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
                  <label for="inactiva" class="ml-2 text-sm text-gray-800">Inactiva</label>
                </div>
              </div>
              <div v-if="localerrors.status" class="text-sm text-red-500 mt-2 pl-2">
                {{ localerrors.status }}
              </div>
            </div>
            <!-- Buttons -->
            <div class="flex justify-end space-x-2">
              <button type="button" @click="$emit('closeModel')"
                class="px-4 py-2 text-sm bg-gray-300 rounded hover:bg-gray-400">
                Cancel
              </button>
              <button type="submit" class="px-4 py-2 text-sm bg-indigo-500 text-white rounded hover:bg-indigo-600">
                {{ form.id ? "Update" : "Add" }} Movie
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue'

const props = defineProps({
  movie: Object,
})
const emit = defineEmits(['closeModel']);
// Reactive state for files
const files = ref([]);

const form = useForm({
  name: props.movie?.name || '',
  director: props.movie?.director || '',
  release_date: props.movie?.release_date || '',
  number: props.movie?.number || '',
  price: props.movie?.price || '',
  image: props.movie?.image || '',
  description: props.movie?.description || '',
  status: props.movie.status || 0,
});
let localerrors = ref({});
let previewUrls = ref(form.image ? `/storage/movie/${form.image}` : '');
// Handle file selection
const previewImage = (event) => {
  const file = event.target.files[0];
  if (file && file.type.startsWith("image/")) {
    form.image = event.target.files[0];
    // console.log(form.image);
    previewUrls = URL.createObjectURL(file);
  }
};

const saveMovie = () => {
  let url = props.movie.id ? route('movie.update', props.movie.id) : route('movie.store');
  form.post(url, {
    onSuccess: (response) => {
      console.log(response);
      emit('closeModel');
    },
    onError: (error) => {
      localerrors.value = error;
    }
  });
};
</script>

<style>
/* Ensure that the page scrollbar scrolls the modal content */
html,
body {
  overflow-y: auto;
  height: 100%;
}
</style>