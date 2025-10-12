<template>
    <div class="size-fit p-4">
        <h1 class="text-black font-bold text-2xl mb-4">Home</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Card 1 -->
            <div
                class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow duration-300"
            >
                <h2 class="text-xl font-bold mb-2">Card 1</h2>
                <p class="text-gray-700">
                    This is a fake card. Hover over me to see the shadow effect.
                </p>
            </div>

            <!-- Card 2 -->
            <div
                class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow duration-300 md:col-span-2"
            >
                <h2 class="text-xl font-bold mb-2">Card 2 (Wider)</h2>
                <p class="text-gray-700">
                    This card takes up two columns on medium screens and above.
                </p>
            </div>

            <!-- Card 3 -->
            <div
                class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow duration-300"
            >
                <h2 class="text-xl font-bold mb-2">Card 3</h2>
                <p class="text-gray-700">Another fake card.</p>
            </div>

            <!-- Card 4 -->
            <div
                class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow duration-300"
            >
                <h2 class="text-xl font-bold mb-2">Card 4</h2>
                <p class="text-gray-700">This is another fake card.</p>
            </div>

            <!-- Card 5 -->
            <div
                class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow duration-300"
            >
                <h2 class="text-xl font-bold mb-2">Card 5</h2>
                <p class="text-gray-700">Yet another fake card.</p>
            </div>

            <!-- Card 6 -->
            <div
                class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow duration-300"
            >
                <h2 class="text-xl font-bold mb-2">Card 6</h2>
                <p class="text-gray-700">And one more for good measure.</p>
            </div>
        </div>
    </div>
</template>
