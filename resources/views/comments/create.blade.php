


<!-- Main modal -->
<div id="crud-modal"  class="hidden overflow-y-auto overflow-x-hiddenh-screen  flex items-center justify-center">
    <div id="inner-modal" class="relative p-4">

            <!-- Modal content -->
            <div class="relative rounded-lg shadow dark:bg-gray-700 ">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Add a comment
                    </h3>
                    <button type="button" onclick="closeModal()" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                </div>
                <!-- Modal body -->

                <form class="p-4 md:p-5 min-w-xl" method="POST" action="{{ route('chirp.comments.store', ['chirp' => $chirp->id]) }}" >
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                            <textarea name="comment" id="description" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-red-500 focus:border-red-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500" placeholder="Leave a comment here :)"></textarea>
                        </div>
                    </div>
                    <x-primary-button  class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                        Submit
                    </x-primary-button>
                </form>
            </div>
    </div>
</div>

<script>
    function openModal() {
        var modal = document.getElementById('crud-modal');
        var innerModal = document.getElementById('inner-modal');
        innerModal.style.width = 'calc(100% - 50%)';

        modal.classList.remove('hidden');
        modal.style.position = 'fixed';
        modal.style.top = '50%';
        modal.style.left = '50%';
        modal.style.transform = 'translate(-50%, -50%)';
        modal.style.width = '100%';

    }

    function closeModal() {
        var modal = document.getElementById('crud-modal');
        modal.classList.add('hidden');
    }
</script>
