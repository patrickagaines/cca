<div
    x-data="{ open: false }"
    class="contents lg:hidden"
>
    <button
        x-on:click="open = !open"
        class="relative w-[30px] h-[21px]"
    >
        <span
            class="
                absolute
                top-0
                left-0
                block
                origin-top-left
                rounded-sm bg-white
                transition-all
                duration-200
                ease-in
                w-[30px]
                h-[3px]
            "
            :class="{'delay-75 rotate-45 w-[27px]': open}"
        ></span>
        <span
            x-show="!open"
            x-transition:enter="transition-all ease-out duration-200 delay-50"
            x-transition:enter-start="opacity-0 w-[0px]"
            x-transition:enter-end="opacity-100 w-[30px]"
            x-transition:leave="transition-all ease-in duration-200"
            x-transition:leave-start="opacity-100 w-[30px]"
            x-transition:leave-end="opacity-0 w-[0px]"
            class="absolute top-1/2 left-0 block -translate-y-1/2 rounded-sm bg-white w-[30px] h-[3px]"
        ></span>
        <span
            class="
                absolute
                bottom-0
                left-0
                block
                origin-bottom-left
                rounded-sm
                bg-white
                transition-all
                duration-200
                ease-in
                w-[30px]
                h-[3px]
            "
            :class="{'delay-75 -rotate-45 w-[27px]': open}"
        ></span>
    </button>

    <div
        x-show="open"
        x-transition:enter="transition duration-[400ms]"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition duration-[400ms]"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed right-0 bottom-0 left-0 bg-opacity-90 top-[60px] bg-ground"
    >

    </div>

</div>
