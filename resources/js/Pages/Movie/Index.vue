<template>
    <div class="p-4 mt-2 flex items-center justify-between bg-indigo-500">
        <h1 class="text-4xl text-white pl-5 font-bold">Movies</h1>
        <button class="px-4 py-2 bg-blue-900 text-white rounded hover:bg-blue-700" @click="openCreateModal">Add
            Movie</button>
    </div>
    <div>
    <!-- Display flash message -->
        <div v-if="$page.props.flash.message"
            class="flex items-center m-1 p-4 mb-4 text-blue-800 bg-blue-50 rounded-lg dark:bg-gray-800 dark:text-blue-400"
            role="alert">
            <svg class="w-4 h-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20" aria-hidden="true">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <div class="ms-3 text-sm font-medium">{{ $page.props.flash.message }}</div>
            <button @click="$page.props.flash.message = null"
                class="ms-auto p-1.5 bg-blue-50 text-blue-500 rounded-lg hover:bg-blue-200 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700"
                aria-label="Close">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"
                    aria-hidden="true">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    </div>
    <!-- Your movie listing or content here -->
    <div class="m-10 shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Image</th>
                    <th class="px-6 py-3">Director</th>
                    <th class="px-6 py-3">Release Date</th>
                    <th class="px-6 py-3">Phone Number</th>
                    <th class="px-6 py-3">Price</th>
                    <th class="px-6 py-3">Description</th>
                    <th class="px-6 py-3">status</th>
                    <th class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody v-for="movie in movies" :key="movie.id">
                <tr class="bg-white border-b">
                    <th class="px-6 py-4 font-medium text-gray-900">{{ movie.name }}</th>
                    <td class="px-6 py-4">
                        <img v-if="movie.image" :src="`/storage/movie/${movie.image}`" :alt="movie.name"
                            class="w-12 h-12 rounded object-cover" />
                    </td>
                    <td class="px-8 py-6">{{ movie.director }}</td>
                    <td class="px-6 py-4">{{ movie.release_date }}</td>
                    <td class="px-6 py-4">{{ movie.number }}</td>
                    <td class="px-6 py-4">{{ movie.price }}</td>
                    <td class="px-6 py-4">{{ movie.description }}</td>
                    <td class="px-6 py-4">{{ movie.status ? 'Active' : 'Inactive' }}</td>
                    <td class="px-6 py-4">
                        <button type="button" @click="editMovie(movie.id)"
                            class="text-blue-600 m-2 hover:underline">Edit</button>
                        <button type="button" @click="deleteMovie(movie.id)"
                            class="text-red-600 hover:underline">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <Model v-if="showModal" @closeModel="showModal = false" :movie="movie" />
</template>

<script setup>
import Model from "@/Pages/Movie/Model.vue"
import axios from "axios";
import { useForm } from '@inertiajs/vue3';
import { ref, } from "vue";

defineProps({
    movies: Object,
});
const form = useForm({});
let movie = {};
// State for modal visibility
const showModal = ref(false);

// Function to open the create modal
const openCreateModal = () => {
    showModal.value = true;
    movie = {};   
};

// Function to edit a movie
const editMovie = async (id) => {
    let url = route('movie.edit', id);
    const res = await axios.get(url);
    movie = res.data;
    showModal.value = true;
};

const deleteMovie = (id) => {
    if (confirm("Are you sure you want to delete this movie?")) {
        let url = route('movie.delete', id);
        const res = form.delete(url);
    }
}

</script>