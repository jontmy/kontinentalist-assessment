<script setup>
import {Head} from '@inertiajs/vue3';
import {ChevronLeftIcon, ChevronRightIcon, HomeIcon} from '@heroicons/vue/20/solid'
import {onMounted, ref} from 'vue'

const page = ref(1)
const stories = ref([])
const isLoading = ref(false)

function next(append) {
    page.value++;
    fetchStories(append);
}

function prev() {
    if (page.value > 1) {
        page.value--;
        fetchStories();
    }
}

function reset() {
    page.value = 1;
    stories.value = [];
    fetchStories();
}

function fetchStories(append) {
    isLoading.value = true;
    if (!append) {
        stories.value = [];
    }
    fetch(`https://cryptodire.kontinentalist.com/api/v1/stories?page=${page.value}`)
        .then(response => response.json())
        .then(data => {
            stories.value = append
                ? [...stories.value, ...data.data]
                : data.data;
        })
        .catch(error => console.error(error))
        .finally(() => isLoading.value = false)
}

onMounted(() => {
    fetchStories()
})
</script>

<template>
    <Head title="Stories"/>
    <div class="flex flex-col min-h-screen items-center text-slate-700 gap-4 pt-12 pb-20 gap-12 p-6">
        <div
            class="flex w-full max-w-[800px]  justify-between sticky top-0 py-4 bg-white border-b border-slate-300 z-10">
            <div class="flex flex-col w-36 gap-0.5">
                <h1 class="font-bold text-3xl">
                    Stories
                </h1>
                <p v-if="isLoading" class="text-sm text-slate-500">
                    Loading...
                </p>
                <p v-else class="text-sm text-slate-500">
                    Showing {{ stories.length }} stories.
                </p>
            </div>
            <div class="flex items-center">
                <button type="button" @click="reset()" class="mx-6">
                    <HomeIcon class="w-5 h-5 text-slate-500/80"/>
                </button>
                <button type="button"
                        @click="prev()"
                        :disabled="page <= 1"
                        class="group border-y border-l border-slate-300 rounded-l p-3 disabled:cursor-not-allowed"
                >
                    <ChevronLeftIcon class="w-6 h-6 text-slate-500 group-disabled:text-slate-200"/>
                </button>
                <p class="border-y border-slate-300 font-bold py-3 text-center w-12 text-slate-600">
                    {{ page }}
                </p>
                <button
                    type="button"
                    @click="next()"
                    :disabled="stories.length === 0 && !isLoading"
                    class="group border-y border-r border-slate-300 rounded-r p-3 disabled:cursor-not-allowed"
                >
                    <ChevronRightIcon class="w-6 h-6 text-slate-500 group-disabled:text-slate-200"/>
                </button>
            </div>
        </div>
        <div v-if="stories.length === 0 && !isLoading">
            <p>
                You've reached the end.
            </p>
        </div>
        <div class="flex flex-col gap-8 max-w-[700px]">
            <div
                v-for="story in stories"
                class="border border-slate-300 rounded shadow-md shadow-slate-200 hover:scale-[1.01] transition-transform"
            >
                <img
                    :src="story.hero_image.url"
                    class="w-full rounded-t mb-4"
                />
                <p class="font-bold text-lg pb-1 px-4">
                    {{ story.title }}
                </p>
                <div v-html="story.dek" class="text-sm px-4 pb-4"/>
            </div>
        </div>
        <button
            type="button"
            @click="next(true)"
            :disabled="stories.length === 0 && !isLoading"
            class="flex items-center border border-slate-300 rounded-r py-3 px-5 disabled:cursor-not-allowed"
        >
            {{ isLoading ? 'Loading...' : 'Load more stories' }}
        </button>
    </div>
</template>
